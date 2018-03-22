<?php

namespace App\Repository\Eloquent;

use App;
use App\Repository\Contracts;
use Illuminate\Container\Container;
use App\Repository\Contracts\EventsInterface;

class EventsRepository extends BaseRepository implements EventsInterface
{
    protected function model()
    {
        return \App\Models\CoinmarketcalEvents::class;
    }

    public function save($events)
    {

    }


}
