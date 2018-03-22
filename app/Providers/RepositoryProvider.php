<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepository();
        $this->registerService();
    }

    public function registerService(){

    }

    public function registerRepository(){
        $this->app->bind("App\Repository\Contracts\RepositoryInterface", "App\Repository\Eloquent\BaseRepository");
        $this->app->bind("App\Repository\Contracts\EventsInterface", "App\Repository\Eloquent\EventsRepository");
    }

}
