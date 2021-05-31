<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ProgressServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Repositories\ProgressDataAccessRepositoryInterface::class,
            \App\Repositories\ProgressDataAccessRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
