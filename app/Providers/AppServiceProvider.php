<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;


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
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " .config('paystack.keys.secret')
            ])->post($url, $data);
        });

        Http::macro('secretKeyGetRequest', function ($url, $data = []) {
            return Http::retry(3, 200)->withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer " .config('paystack.keys.secret')
            ])->get($url, $data);
        });

        PendingRequest::macro(
            'paystack',
            fn(): PendingRequest => PendingRequest::acceptJson()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . config('paystack.keys.secret')
                ])
                ->baseUrl(url: config('paystack.url.base_url'))
                // ->withToken(token: 'Bearer '.config('paystack.keys.secret')),
        );

        Http::macro('mailjet', function ($url, $data = []) {
            $publicKey = config('mailjet.keys.public');
            $secretKey = config('mailjet.keys.secret');
        
            return Http::retry(3, 200, function ($exception) {
                // return $exception instanceof RequestException;
            })->withBasicAuth($publicKey, $secretKey)
              ->withHeaders([
                  'Content-Type' => 'application/json',
              ])->post($url, $data);
        });
    }
}
