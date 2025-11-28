<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class positions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Seed Positions_levels
        $positionLevels = [
            ['name' => 'Junior', 'description' => 'Junior Level Position'],
            ['name' => 'Mid', 'description' => 'Mid Level Position'],
            ['name' => 'Senior', 'description' => 'Senior Level Position'],
        ];

        foreach ($positionLevels as $level) {
            DB::table('position_levels')->insert([
                'code' => strtoupper($faker->bothify('LVL-###??')),
                'name' => $level['name'],
                'rank_order' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Seed Positions
        for ($i = 1; $i <= 10; $i++) {
            DB::table('positions')->insert([
                'position_level_id' => rand(1, count($positionLevels)),
                'code' => strtoupper($faker->bothify('POS-###??')),
                'name' => $faker->jobTitle,
                'parent_id' => null,
                'is_managerial' => $faker->randomElement(['Y', 'N']),
                'description' => $faker->sentence,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
