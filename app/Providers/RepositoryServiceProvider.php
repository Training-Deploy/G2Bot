<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserEloquentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Member\MemberRepositoryInterface::class,
            \App\Repositories\Member\MemberEloquentRepository::class
        );

        $this->app->singleton(
            \App\Repositories\Bot\BotRepositoryInterface::class,
            \App\Repositories\Bot\BotEloquentRepository::class
        );
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
