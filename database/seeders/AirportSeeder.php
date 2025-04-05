<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AirportSeeder extends Seeder
{
    public function run(): void
    {
        $airports = [
            [
                'name' => 'Los Angeles International Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 33.9416,
                    'longitude' => -118.4085,
                ],
                'airlines' => [1, 2]
            ],
            [
                'name' => 'Heathrow Airport',
                'country_id' => 2,
                'position' => [
                    'latitude' => 33.9416,
                    'longitude' => -118.4085,
                ],
                'airlines' => [2, 3]
            ],
            [
                'name' => 'Charles de Gaulle Airport',
                'country_id' => 3,
                'position' => [
                    'latitude' => 49.0097,
                    'longitude' => 2.5479,
                ],
                'airlines' => [1, 3]
            ],
            [
                'name' => 'Frankfurt Airport',
                'country_id' => 4,
                'position' => [
                    'latitude' => 50.0379,
                    'longitude' => 8.5622,
                ],
                'airlines' => [1, 2, 3]
            ],
            [
                'name' => 'Tokyo Haneda Airport',
                'country_id' => 5,
                'position' => [
                    'latitude' => 35.5494,
                    'longitude' => 139.7798,
                ],
                'airlines' => [1]
            ],
        ];

        foreach ($airports as $airport) {
            DB::table('positions')->updateOrInsert(
                [
                    'latitude' => $airport['position']['latitude'],
                    'longitude' => $airport['position']['longitude']
                ],
                []
            );

            $positionId = DB::table('positions')
                ->where('latitude', $airport['position']['latitude'])
                ->where('longitude', $airport['position']['longitude'])
                ->value('id');

            $airportId = DB::table('airports')->updateOrInsert(
                ['name' => $airport['name']],
                [
                    'country_id' => $airport['country_id'],
                    'position_id' => $positionId,
                ]
            );

            $airportId = DB::table('airports')
                ->where('name', $airport['name'])
                ->value('id');

            if (isset($airport['airlines'])) {
                foreach ($airport['airlines'] as $airlineId) {
                    DB::table('airport_airline')->updateOrInsert(
                        ['airport_id' => $airportId, 'airline_id' => $airlineId]
                    );
                }
            }
        }

        $airportNames = array_column($airports, 'name');
        DB::table('airports')->whereNotIn('name', $airportNames)->delete();
    }
}
