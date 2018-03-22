<?php

namespace App\Repository\Contracts;

use App\Repository;

interface EventsInterface extends RepositoryInterface
{
    public function save($events);
}
