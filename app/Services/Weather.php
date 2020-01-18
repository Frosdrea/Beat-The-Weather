<?php

namespace App\Services;

class Weather
{
    protected function sendRequest($apiCall) {

        $url = 'https://api.meteo.lt/v1/'.$apiCall;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response, true);

        return $response;
    }

    public function currentWeather($city) {

        $response = $this->sendRequest('places/'.$city.'/forecasts/long-term');

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
