<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class units extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Seed Unit Types
        $unitTypes = [
            ['name' => 'Department', 'description' => 'Hospital Department'],
            ['name' => 'Division', 'description' => 'Hospital Division'],
            ['name' => 'Ward', 'description' => 'Patient Ward'],
        ];

        foreach ($unitTypes as $type) {
            DB::table('unit_types')->insert([
                'name' => $type['name'],
                'description' => $type['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Seed Units
        for ($i = 1; $i <= 10; $i++) {
            DB::table('units')->insert([
                'unit_type_id' => rand(1, count($unitTypes)),
                'code' => strtoupper($faker->bothify('UNIT-###??')),
                'name' => $faker->company,
                'cost_center_code' => strtoupper($faker->bothify('CC-###??')),
                'is_service_unit' => $faker->randomElement(['Y', 'N']),
                'is_active' => 'Y',
                'description' => $faker->sentence,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
