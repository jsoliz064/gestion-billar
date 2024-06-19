<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait ReverseGeocodeTrait
{
    public function getAddress($lat, $lng)
    {
        try {
            $response = Http::get('https://nominatim.openstreetmap.org/reverse', [
                'format' => 'json',
                'lat' => $lat,
                'lon' => $lng,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['address'])) {
                    return $data['address'];
                }
            }
            return null;
        } catch (\Throwable $th) {
            return null;
        }
    }

    public function getAddressResume($lat, $lng)
    {
        $address = $this->getAddress($lat, $lng);
        if ($address == null) return null;
        $calle = isset($address['road']) ? $address['road'] : null;
        $barrio = isset($address['neighbourhood']) ? $address['neighbourhood'] : null;
        $ciudad = isset($address['state']) ? $address['state'] : null;
        return "{$calle}, {$barrio}, {$ciudad}";
    }
}
