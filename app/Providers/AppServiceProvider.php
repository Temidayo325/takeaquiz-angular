<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);

        Http::macro('secretKeyRequest', function ($url, $data = []) {
            return Http::retry(3, 200)->withHeaders([
                'content_type' => 'Content-Type: application/json',
                'authorization' => "Bearer " .config('paystack.keys.secret')
            ])->post($url, $data);
        });

    }
}
