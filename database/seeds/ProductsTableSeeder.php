<?php

use Illuminate\Database\Seeder;
use App\Product;
use Facades\App\Services\Weather;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $allPossibleWeatherConditions = Weather::allPossibleWeatherConditions();

        foreach ($allPossibleWeatherConditions as $weatherKey => $weather) {
            for ($i = 1; $i <= 10; $i++) {
                Product::create([
                    'sku' => $faker->ean8(),
                    'name' => $faker->colorName().' '.$faker->word(),
                    'price' => $faker->randomFloat(null, 10, 1000),
                    'weather' => $weatherKey,
                ]);
            }
        }
    }
}
