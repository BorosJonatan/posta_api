<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\County;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    const CITIES = [
        'Budapest' => [
            [
                'name' => 'Budapest',
                'zip_code' => '1051',
                'population' => 1685000,
            ],
        ],

        'Pest' => [
            [
                'name' => 'Vác',
                'zip_code' => '2600',
                'population' => 33000,
            ],
            [
                'name' => 'Dunakeszi',
                'zip_code' => '2120',
                'population' => 46000,
            ],
            [
                'name' => 'Szentendre',
                'zip_code' => '2000',
                'population' => 28000,
            ],
        ],

        'Győr-Moson-Sopron' => [
            [
                'name' => 'Győr',
                'zip_code' => '9021',
                'population' => 130000,
            ],
            [
                'name' => 'Sopron',
                'zip_code' => '9400',
                'population' => 62000,
            ],
        ],

        'Borsod-Abaúj-Zemplén' => [
            [
                'name' => 'Miskolc',
                'zip_code' => '3525',
                'population' => 150000,
            ],
            [
                'name' => 'Kazincbarcika',
                'zip_code' => '3700',
                'population' => 25000,
            ],
        ],

        'Csongrád-Csanád' => [
            [
                'name' => 'Szeged',
                'zip_code' => '6720',
                'population' => 160000,
            ],
            [
                'name' => 'Hódmezővásárhely',
                'zip_code' => '6800',
                'population' => 44000,
            ],
        ],
    ];

    public function run(): void
    {
        foreach (self::CITIES as $countyName => $cities) {
            $county = County::where('name', $countyName)->firstOrFail();

            foreach ($cities as $city) {
                City::create([
                    'name' => $city['name'],
                    'zip_code' => $city['zip_code'],
                    'population' => $city['population'],
                    'county_id' => $county->id,
                ]);
            }
        }
    }
}