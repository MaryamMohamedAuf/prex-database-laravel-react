<?php

namespace App\Providers;
use App\Services\CohortClient;

use Illuminate\Support\ServiceProvider;
//use App\Models\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CohortClient::class, function ($app) {
            return new CohortClient();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);

    }
}
