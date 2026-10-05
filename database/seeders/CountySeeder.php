<?php

namespace Database\Seeders;

use App\Models\County;
use Illuminate\Database\Seeder;

class CountySeeder extends Seeder
{
    const COUNTIES = [
        [
            'name' => 'Budapest',
            'coatofarms' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/budapest.jpg',
        ],
        [
            'name' => 'Pest',
            'coatofarms' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/pest.jpg',
        ],
        [
            'name' => 'Győr-Moson-Sopron',
            'coatofarms' => 'https://nemzetijelkepek.hu/sites/default/files/2022-06/gyor.jpg',
        ],
        [
            'name' => 'Borsod-Abaúj-Zemplén',
            'coatofarms' => 'https://www.nemzetijelkepek.hu/sites/default/files/2022-06/borsod.jpg',
        ],
        [
            'name' => 'Csongrád-Csanád',
            'coatofarms' => 'https://nemzetijelkepek.hu/sites/default/files/2022-06/csongrad.jpg',
        ],
    ];

    public function run(): void
    {
        foreach (self::COUNTIES as $county) {
            County::create([
                'name' => $county['name'],
                'coatofarms' => $county['coatofarms'],
            ]);
        }
    }
}