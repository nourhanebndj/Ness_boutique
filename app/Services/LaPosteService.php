<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LaposteService
{
    protected $token;

    public function __construct()
    {
        $this->token = config('services.laposte.token');
    }

    public function getGeolocation($ip)
    {
        $response = Http::withToken($this->token)
            ->get(config('services.laposte.geo_url') . "/locate?ip=$ip");

        return $response->json();
    }

    public function reverseGeolocation($lat, $lon)
    {
        $response = Http::withToken($this->token)
            ->get(config('services.laposte.reverse_geo_url') . "/locate?latitude=$lat&longitude=$lon");

        return $response->json();
    }

    public function estimateShipping($code_postal)
    {
        $response = Http::withToken($this->token)
            ->get(config('services.laposte.simtao_url') . "/tarif/$code_postal");

        return $response->json();
    }

    public function trackParcel($trackingNumber)
    {
        $response = Http::withToken($this->token)
            ->get(config('services.laposte.tracking_url') . "/$trackingNumber");

        return $response->json();
    }
}

