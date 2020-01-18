<?php

namespace App\Services;

class Weather
{
    public function currentWeather($city) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.meteo.lt/v1/places/'.$city.'/forecasts/long-term');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response, true);

        if (!isset($response['forecastTimestamps'])) {
            return null;
        }

        $forecastTimestamps = collect($response['forecastTimestamps']);
        $currentforecastTimestamp = $forecastTimestamps
            ->where('forecastTimeUtc', now()->startOfHour()->startOfMinute())
            ->first();

        if (!$currentforecastTimestamp) {
            return null;
        }

        $weather = $currentforecastTimestamp['conditionCode'] ?? null;

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
