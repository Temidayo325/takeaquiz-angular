<?php
declare(strict_types = 1);

namespace App\Services;
use Illuminate\Support\Facades\Http;

final class Maps
{
    public static function GenerateLatnLongFromShortUrl(string $shortenedUrl):object
    {
        try {
            // Resolve the shortened URL to get the actual Google Maps link
            $response = Http::get($shortenedUrl);
            $longUrl = (string) $response->effectiveUri(); // Get final redirected URL

            // Extract latitude & longitude from the resolved URL
            if (!preg_match('/@([-.\d]+),([-.\d]+)/', $longUrl, $matches)) {
                throw new \Exception("Unable to resolve the provided Google map link");
            }
            return (object) [
                'latitude' => $matches[1],
                'longitude' => $matches[2]
            ];
            
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }
}