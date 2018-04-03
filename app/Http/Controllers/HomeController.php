<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Repository\Contracts\EventsInterface as Events;
use Carbon\Carbon;
use App\Services\DateTimeService as DateTime;
use Illuminate\Support\Facades\Auth;

class HomeController extends BaseController
{
    protected $events;
    protected $dateTime;

    public function __construct(Events $events, DateTime $dateTime)
    {
        $this->events = $events;
        $this->dateTime = $dateTime;
    }

    public function index()
    {
        $currentDate = Carbon::now()->format('Y-m-d');
        $dayOfWeek = $this->dateTime->getDayOfWeek($currentDate);
        $currentDay = explode('-', $currentDate)[2];
        $listEventToday = $this->events->findWhereAll(['date_convert' => $currentDate . ' 00:00:00']);

        return view('home.index', compact('listEventToday', 'currentDay', 'dayOfWeek', 'currentDate'));
    }
}
