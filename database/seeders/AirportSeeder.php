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
                'name' => 'Brac Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 43.2858330800,
                    'longitude' => 16.6797220300,
                ],
                'airlines' => [1, 2]
            ],
            [
                'name' => 'Dubrovnik Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 42.5622383800,
                    'longitude' => 18.2657594100,
                ],
                'airlines' => [1, 3]
            ],
            [
                'name' => 'Losinj Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 44.5655036300,
                    'longitude' => 14.3979867300,
                ],
                'airlines' => [1, 3]
            ],
            [
                'name' => 'Osijek Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 45.4589001100,
                    'longitude' => 18.8232948400,
                ],
                'airlines' => [1, 2, 3]
            ],
            [
                'name' => 'Pula Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 44.8926854400,
                    'longitude' => 13.9166197000,
                ],
                'airlines' => [1]
            ],
            [
                'name' => 'Rijeka Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 45.2198913100,
                    'longitude' => 14.5674886900,
                ],
                'airlines' => [1]
            ],
            [
                'name' => 'Split Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 43.5385091500,
                    'longitude' => 16.2985301000,
                ],
                'airlines' => [1]
            ],
            [
                'name' => 'Zadar Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 44.0944431800,
                    'longitude' => 15.3528740800,
                ],
                'airlines' => [1]
            ],
            [
                'name' => '	Zagreb Airport',
                'country_id' => 1,
                'position' => [
                    'latitude' => 45.7383556500,
                    'longitude' => 16.0606726300,
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
