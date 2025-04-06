<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            ['code' => 'CRO', 'name' => 'Croatia'],
            ['code' => 'USA', 'name' => 'United States'],
            ['code' => 'GBR', 'name' => 'United Kingdom'],
            ['code' => 'FRA', 'name' => 'France'],
            ['code' => 'DEU', 'name' => 'Germany'],
            ['code' => 'JPN', 'name' => 'Japan'],
            ['code' => 'AUS', 'name' => 'Australia'],
            ['code' => 'CAN', 'name' => 'Canada'],
            ['code' => 'ITA', 'name' => 'Italy'],
            ['code' => 'ESP', 'name' => 'Spain'],
            ['code' => 'CHN', 'name' => 'China'],
        ];

        foreach ($countries as $country) {
            DB::table('countries')->updateOrInsert(
                ['code' => $country['code']],
                ['name' => $country['name']]
            );
        }

        $countryCodes = array_column($countries, 'code');
        DB::table('countries')->whereNotIn('code', $countryCodes)->delete();
    }
}
