<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Sample countries
        $countries = [
            ['code' => 'US', 'name' => 'United States', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'GB', 'name' => 'United Kingdom', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'DE', 'name' => 'Germany', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'FR', 'name' => 'France', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['code' => 'JP', 'name' => 'Japan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        DB::table('countries')->insert($countries);
    }
}
