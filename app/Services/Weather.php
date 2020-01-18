<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class Weather
{
    protected function sendRequest($query) {

        $url = 'https://api.meteo.lt/v1/'.$query;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response, true);

        return $response;
    }

    protected function validate($data, $rules) {

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return [
                'valid' => false,
                'errors' => $validator->errors()->all(),
            ];
        }

        return ['valid' => true];
    }

    public function currentWeather($city) {

        $validationResult = $this->validate(compact('city'), [
            'city' => 'string|max:50',
        ]);

        if (!$validationResult['valid']) {
            return null;
        }

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
