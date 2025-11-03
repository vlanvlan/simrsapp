<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class financial_institutions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed financial institutions data here
        $faker = Faker::create();
        $institutions = [
            ['name' => 'Bank A', 'code' => 'BKA', 'institution_category' => 'Bank'],
            ['name' => 'Credit Union B', 'code' => 'CUB', 'institution_category' => 'Credit Union'],
            ['name' => 'Microfinance C', 'code' => 'MFC', 'institution_category' => 'Microfinance'],
        ];

        foreach ($institutions as $institution) {
            DB::table('financial_institutions')->insert([
                'name' => $institution['name'],
                'code' => $institution['code'],
                'institution_category' => $institution['institution_category'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Seed financial institution branches data here
        $branches = [
            ['institution_code' => 'BKA', 'code' => 'BKA001', 'name' => 'Bank A - Main Branch', 'address' => '123 Main St', 'city' => 'Cityville', 'phone' => '123-456-7890'],
            ['institution_code' => 'CUB', 'code' => 'CUB001', 'name' => 'Credit Union B - Downtown', 'address' => '456 Elm St', 'city' => 'Townsville', 'phone' => '234-567-8901'],
            ['institution_code' => 'MFC', 'code' => 'MFC001', 'name' => 'Microfinance C - Uptown', 'address' => '789 Oak St', 'city' => 'Villageville', 'phone' => '345-678-9012'],
        ];

        foreach ($branches as $branch) {
            $institution = DB::table('financial_institutions')->where('code', $branch['institution_code'])->first();
            if ($institution) {
                DB::table('fi_branches')->insert([
                    'institution_id' => $institution->id,
                    'code' => $branch['code'],
                    'name' => $branch['name'],
                    'address' => $branch['address'],
                    'city' => $branch['city'],
                    'phone' => $branch['phone'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
