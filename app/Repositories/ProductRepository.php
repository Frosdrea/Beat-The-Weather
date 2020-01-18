<?php

namespace App\Repositories;

use App\Product;

class ProductRepository {

    protected $model;

    public function __construct(Product $model){
        $this->model = $model;
    }

    public function getListByWeather($weather) {

        return $this->model
            ->where('weather', $weather)
            ->inRandomOrder()
            ->take(5)
            ->get(['sku', 'name', 'price']);
    }
}