<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Symfony\Component\DomCrawler\Crawler;
use App\Services\CalendarService as CalendarService;
use App\Repository\Contracts\EventsInterface as EventsInterface;
use App\Models\CoinmarketcalEvents;
use Statickidz\GoogleTranslate;
use Google_Service_Drive_Resource_Files;

class GetCoinEventCommand extends Command
{
    protected $calendar;
    protected $event;
    protected $client;
    protected $clientC;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GetCoinEvent:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get new coin events every hour';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CalendarService $calendar, EventsInterface $event)
    {
        $this->client = $this->createAuthenticatedGoogleDriverClient();
        $this->clientC = $this->createAuthenticatedGoogleClientCalendar();
        $this->calendar = $calendar;
        $this->event = $event;
        parent::__construct();
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        echo "Start : " . Carbon::now() . "\n";
        $url = "https://coinmarketcal.com/";
        $crawler = new Crawler($this->getData($url));
        $crawler->filterXPath('//nav[@class="pagination-wrapper pagination"]')->each(function ($node) use (&$totalPage) {
            $node->filter('a')->each(function ($item) use (&$totalPage) {
                $latestLink = trim($item->attr('href'));
                $totalPage = str_replace('/?page=', '', $latestLink);
            });
        });

        //loop to per page
        for ($i = 1; $i <= $totalPage; $i++) {
            $data = [];
            //declare array dataCrawls
            $dataCrawls = [];
            $url = 'https://coinmarketcal.com/?page=' . $i;
            $dataPerPage = $this->getData($url);
            $crawlerPerPage = new Crawler($dataPerPage);
            $crawlerPerPage->filterXPath('//div[@class="row multi-columns-row"]/article')->each(function ($node) use (&$data, &$dataCrawls, &$coinNameEventsArray, &$controller) {
                //declare variables used
                $coin_name = '';
                $date_event = '';
                $content_event = '';
                $source_url = '';
                $imgSource = null;

                //filter to get date_event & coin_name
                $node->filter('.content-box-general > h5')->each(function ($item, $index) use (&$date_event, &$coin_name) {
                    if ($index == 0) {
                        $date_event = trim($item->filter('strong')->text());
                    } elseif ($index == 1) {
                        $coin_name = trim($item->text());
                    }
                });

                //filter to get content_event
                $content_event = trim($node->filter('.content-box-general > .content-box-info > .description')->text());

                //filter to get source_url
                $node->filter('.content-box-general > .content-box-info > a')->each(function ($item, $index) use (&$source_url, &$imgSource) {
                    if ($index == 0) {
                        $img_url = 'https://coinmarketcal.com/' . trim($item->attr('href'));
                        $imgSource = @file_get_contents($img_url);
                    }
                    if ($index == 1) {
                        $source_url = trim($item->attr('href'));
                    }
                });

                $start = Carbon::createFromFormat('d F Y', $date_event, 'GMT+7');
                $end = Carbon::createFromFormat('d F Y', $date_event, 'GMT+7');

                $dataCrawls = [
                    'coin_name' => $coin_name,
                    'content_event' => $content_event,
                    'content_event_jp' => $this->translate($content_event),
                    'source_url' => $source_url,
                    'date' => $date_event,
                    'start' => $start,
                    'end' => $end,
                ];

                $conditions = [
                    ['coin_name', '=', $coin_name],
                    ['content_event', '=', $content_event],
                    ['date', '=', $date_event]
                ];


                $googleDriver = new \Google_Service_Drive($this->client);

                $file = new \Google_Service_Drive_DriveFile([
                    'name' => uniqid().'.png',
                    'parents' => array('1GbIVJLQxr8N04eAvzKVYzT3xqHQiwgPW')
                ]);

                $fileId = $googleDriver->files->create($file, [
                    'data' => $imgSource,
                    'mimeType' => 'image/png',
                    'fields' => 'id'
                ]);

                //$checkEventExist = $this->event->firstWhere($conditions);
                //if(count($checkEventExist) == 0){
                $data[] = $dataCrawls;
                $this->calendar->save($dataCrawls, $fileId->id, $this->clientC);
                echo "save : " . Carbon::now() . "\n" . $coin_name . "\n";

            });

            //CoinmarketcalEvents::insert($data);
        }
        echo "End : " . Carbon::now() . "\n";

    }

    private function getData($url)
    {

        static $ch = null;

        if (is_null($ch)) {
            $ch = curl_init();
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        $res = curl_exec($ch);

        return $res;
    }

    private function translate($content)
    {
        $source = 'en';
        $target = 'ja';
        $text = $content;

        $trans = new GoogleTranslate();
        $result = $trans->translate($source, $target, $text);

        return $result;
    }

    public function createAuthenticatedGoogleDriverClient()
    {
        $client = new \Google_Client();

        $client->setScopes([
            \Google_Service_Drive::DRIVE_FILE,
        ]);

        $client->setAuthConfig(storage_path('app/google-calendar/google-driver-my-project.json'));

        return $client;
    }

    public function createAuthenticatedGoogleClientCalendar()
    {
        $client = new \Google_Client();

        $client->setScopes([
            \Google_Service_Calendar::CALENDAR,
        ]);

        $client->setAuthConfig(storage_path('app/google-calendar/service-account-credentials.json'));

        return $client;
    }

//calendar-demo@optimistic-yew-197612.iam.gserviceaccount.com
}
