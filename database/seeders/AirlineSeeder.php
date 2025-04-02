<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirlineSeeder extends Seeder
{
    public function run(): void
    {
        $airlines = [
            ['name' => 'American Airlines', 'country_id' => 1],
            ['name' => 'British Airways', 'country_id' => 2],
            ['name' => 'Air France', 'country_id' => 3],
            ['name' => 'Lufthansa', 'country_id' => 4],
            ['name' => 'Japan Airlines', 'country_id' => 5],
        ];

        foreach ($airlines as $airline) {
            DB::table('airlines')->updateOrInsert(
                ['name' => $airline['name']],
                ['country_id' => $airline['country_id']]
            );
        }

        $airlineNames = array_column($airlines, 'name');
        DB::table('airlines')->whereNotIn('name', $airlineNames)->delete();
    }
}
