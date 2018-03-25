<?php

namespace App\Repository\Eloquent;

use App;
use App\Repository\Contracts;
use Illuminate\Container\Container;
use App\Repository\Contracts\EventsInterface;

class HomeRepository extends BaseRepository implements HomeInterface
{
    protected function model()
    {
        return \App\Models\CoinmarketcalEvents::class;
    }


}
