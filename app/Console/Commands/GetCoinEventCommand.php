<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use App\Services\CalendarService as CalendarService;
use App\Repository\Contracts\EventsInterface as EventsInterface;
use App\Models\CoinmarketcalEvents;

class GetCoinEventCommand extends Command
{
    protected $calendar;
    protected $event;

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
        echo "Start : ".Carbon::now()."\n";
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
                $node->filter('.content-box-general > .content-box-info > a')->each(function ($item, $index) use (&$source_url) {
                    if ($index == 1) {
                        $source_url = trim($item->attr('href'));
                    }
                });

                $start = Carbon::createFromFormat('d F Y', $date_event, 'GMT+7')->startOfDay();
                $end = Carbon::createFromFormat('d F Y', $date_event, 'GMT+7')->endOfDay();

                $dataCrawls = [
                    'coin_name' => $coin_name,
                    'content_event' => $content_event,
                    'date' => $date_event,
                    'start' => $start,
                    'end' => $end
                ];

                $conditions = [
                    ['coin_name' ,'=', $coin_name],
                    ['content_event' ,'=', $content_event],
                    ['date', '=', $date_event]
                ];

                $checkEventExist = $this->event->firstWhere($conditions);
                if(count($checkEventExist) == 0){
                    $data[] = $dataCrawls;
                    $this->calendar->save($dataCrawls);
                    echo "save : ".Carbon::now()."\n".$coin_name."\n";
                }

            });

            CoinmarketcalEvents::insert($data);
        }
        echo "End : ".Carbon::now()."\n";

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

    //calendar-demo@optimistic-yew-197612.iam.gserviceaccount.com
}
