<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepository;
use Facades\App\Services\Weather;

class ProductApiController extends Controller {

    protected $repository;

    public function __construct(ProductRepository $repository) {

        $this->repository = $repository;
    }

    public function indexByWeatherInCity($city) {

        $weather = Weather::currentWeather($city);
        $products = $this->repository->getListByWeather($weather);

        if (!$weather) {
            return response()->json([
                'city' => $city,
                'message' => __("Failed to get weather info."),
                'weather_data_provider' => 'LHMT',
            ], 400);
        }

        return response()->json([
            'city' => $city,
            'current_weather' => $weather,
            'recommended_products' => $products,
            'weather_data_provider' => 'LHMT',
        ], 200);
    }
}
