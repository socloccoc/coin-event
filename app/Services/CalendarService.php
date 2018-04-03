<?php
/**
 * Created by PhpStorm.
 * User: daidv
 * Date: 3/13/2018
 * Time: 9:59 AM
 */

namespace App\Services;

use Spatie\GoogleCalendar\Event;
use Google_Client;

class CalendarService
{
    protected $service;

    public function __construct()
    {
    }

    /**
     * Create a new event
     *
     * @param array $events
     */
    public function save($events, $fileId, $clientC)
    {

        $event = new Event();

        $event->name = '【' . $events['coin_name'] . '】' . $events['content_event'];
        $event->startDate = $events['date_convert'];
        $event->endDate = $event->startDate;

        $event->description = '＜イベント内容＞'."\n\n".$events['content_event'] . "\n\n" . $events['content_event_jp']."\n\n".'＜ソース元＞'."\n\n".$events['source_url']."\n\n";

        try {
            $resource = $event->save();
            $calendarService = new \Google_Service_Calendar($clientC);
            $event = $calendarService->events->get(env('CALENDAR_ID'), $resource->id);

            $attachments = $event->attachments;

            $attachments[] = array(
                'fileUrl' => 'https://drive.google.com/open?id=' . $fileId,
            );

            $changes = new \Google_Service_Calendar_Event(array(
                'attachments' => $attachments
            ));

            $calendarService->events->patch(env('CALENDAR_ID'), $resource->id, $changes, array(
                'supportsAttachments' => TRUE
            ));
        } catch (Google_ServiceException $e ) {
            print_r($e);
        }

    }


}