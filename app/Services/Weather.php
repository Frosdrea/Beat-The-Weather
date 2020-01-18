<?php

namespace App\Services;

class Weather
{
    public function currentWeather($city) {

        $weather = 'lietus';

        return $weather;
    }

    public function allPossibleWeatherConditions() {

        return [
            'clear' => 'giedra',
            'isolated-clouds' => 'mažai debesuota',
            'scattered-clouds' => 'debesuota su pragiedruliais',
            'overcast' => 'debesuota',
            'light-rain' => 'nedidelis lietus',
            'moderate-rain' => 'lietus',
            'heavy-rain' => 'smarkus lietus',
            'sleet' => 'šlapdriba',
            'light-snow' => 'nedidelis sniegas',
            'moderate-snow' => 'sniegas',
            'heavy-snow' => 'smarkus sniegas',
            'fog' => 'rūkas',
            'na' => 'oro sąlygos nenustatytos',
        ];
    }
}
