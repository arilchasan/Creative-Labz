<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = 'd9cc3e0463ce8ea9546ea9b012d7aba6';
    }

    public function getProvinces()
    {
        $response = Http::get("https://pro.rajaongkir.com/api/province", [
            'key' => $this->apiKey,
        ]);

        return $response->json();
    }

    public function getCities($province_id)
    {
        $response = Http::get("https://pro.rajaongkir.com/api/city", [
            'key'       => $this->apiKey,
            'province'  => $province_id,
        ]);

        return $response->json();
    }

    public function getSubdistricts($city_id)
    {
        $response = Http::get("https://pro.rajaongkir.com/api/subdistrict", [
            'key'  => $this->apiKey,
            'city' => $city_id,
        ]);

        return $response->json();
    }

    public function getCost()
    {
        $response = Http::get("https://pro.rajaongkir.com/api/cost", [
            'key'           => $this->apiKey,
            'origin'        => request()->origin,
            'destination'   => request()->destination,
            'weight'        => request()->weight,
            'courier'       => request()->courier,
        ]);

        return $response->json();
    }

    
    public function CitiesDetail($id) {
        $response = Http::get("https://pro.rajaongkir.com/api/city", [
            'key' => $this->apiKey,
            'id' => $id,
        ]);

        return $response->json();
    }
}
