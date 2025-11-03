<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class employees extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Seed Employees
        for ($i = 1; $i <= 20; $i++) {
            DB::table('employees')->insert([
                'employee_code' => 'EMP' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'name' => $faker->name,
                'position_id' => rand(1, 5),
                'unit_id' => rand(1, 3),
                'employment_status' => $faker->randomElement(['permanent', 'contract', 'intern']),
                'hire_date' => $faker->date(),
                'end_date' => null,
                'nik' => $faker->numerify('###########'),
                'npwp' => $faker->numerify('##.###.###.#-###.###'),
                'gender' => $faker->randomElement(['male', 'female']),
                'birth_place' => $faker->city,
                'birth_date' => $faker->date(),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'photo' => null,
                'supervisor_id' => $i > 1 ? rand(1, $i - 1) : null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
