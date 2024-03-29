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

        if (!$weather) {
            return response()->json([
                'city' => $city,
                'message' => __("Failed to get weather info."),
                'weather_data_provider' => config('app.weather_data_provider'),
            ], 400);
        }

        $products = $this->repository->getListByWeather($weather);

        return response()->json([
            'city' => $city,
            'current_weather' => $weather,
            'recommended_products' => $products,
            'weather_data_provider' => config('app.weather_data_provider'),
        ], 200);
    }
}
