<?php

namespace App\Http\Controllers;

use Request;
use Illuminate\Routing\Controller as BaseController;
use App\Repository\Contracts\EventsInterface as Events;
use Carbon\Carbon;
use App\Services\DateTimeService as DateTime;

class AjaxController extends BaseController
{
    protected $events;
    protected $dateTime;
    public function __construct(Events $events, DateTime $dateTime)
    {
        $this->events = $events;
        $this->dateTime = $dateTime;
    }

    public function getEventOfDay(){
        if (Request::ajax()) {
            $date = Request::get('dateSelect');
            $dayOfWeek = $this->dateTime->getDayOfWeek($date);
            $currentDay = explode('-',$date)[2];
            $listEventToday = $this->events->findWhereAll(['start'=>$date.' 00:00:00']);
            return view('ajax.eventofday',compact('listEventToday','currentDay','dayOfWeek'));
        }

    }
}
