<?php
/**
 * Created by PhpStorm.
 * User: daidv
 * Date: 3/13/2018
 * Time: 9:59 AM
 */
namespace App\Services;
use Spatie\GoogleCalendar\Event;

class CalendarService
{
    public function __construct(){}

    /**
     * Create a new event
     *
     * @param array $events
     */
    public function save($events){
        $event = new Event();
        $event->name = '【'.$events['coin_name'].'】'.$events['content_event'];
        $event->startDateTime = $events['start'];
        $event->endDateTime = $events['end'];
        $event->save();
    }


}