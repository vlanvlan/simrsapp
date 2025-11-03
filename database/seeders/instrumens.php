<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class instrumens extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed instrumens data here
        $faker = Faker::create();
        $instrumens = [
            ['type' => 'Deposit', 'institution_code' => 'BKA', 'branch_code' => 'BKA001', 'currency' => 'IDR'],
            ['type' => 'Bond', 'institution_code' => 'CUB', 'branch_code' => 'CUB001', 'currency' => 'IDR'],
        ];

        foreach ($instrumens as $instrumen) {
            $institution = DB::table('financial_institutions')->where('code', $instrumen['institution_code'])->first();
            $branch = DB::table('fi_branches')->where('code', $instrumen['branch_code'])->first();

            if ($institution && $branch) {
                DB::table('instrumens')->insert([
                    'type' => $instrumen['type'],
                    'institution_id' => $institution->id,
                    'branch_id' => $branch->id,
                    'currency' => $instrumen['currency'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // Seed deposits
        $instrumenDeposit = DB::table('instrumens')->where('type', 'Deposit')->first();
        if ($instrumenDeposit) {
            for ($i = 0; $i < 5; $i++) {
                DB::table('deposits')->insert([
                    'instrumen_id' => $instrumenDeposit->id,
                    'deposit_number' => 'DEP' . $faker->unique()->numerify('#####'),
                    'start_date' => $faker->date(),
                    'maturity_date' => $faker->date(),
                    'principal_amount' => $faker->randomFloat(2, 1000000, 10000000),
                    'interest_rate' => $faker->randomFloat(2, 1, 10),
                    'interest_payment_frequency' => $faker->randomElement(['monthly', 'quarterly', 'annually']),
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // Seed bonds
        $instrumenBond = DB::table('instrumens')->where('type', 'Bond')->first();
        if ($instrumenBond) {
            for ($i = 0; $i < 5; $i++) {
                DB::table('bonds')->insert([
                    'instrumen_id' => $instrumenBond->id,
                    'bond_series' => 'BND' . $faker->unique()->numerify('#####'),
                    'issue_date' => $faker->date(),
                    'maturity_date' => $faker->date(),
                    'face_value' => $faker->randomFloat(2, 1000000, 10000000),
                    'coupon_rate' => $faker->randomFloat(2, 1, 10),
                    'coupon_payment_frequency' => $faker->randomElement(['semi-annual', 'annual']),
                    'status' => 'active',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // Additional seeding for deposit_balances
        $deposits = DB::table('deposits')->get();
        foreach ($deposits as $deposit) {
            for ($j = 0; $j < 3; $j++) {
                DB::table('deposit_balances')->insert([
                    'deposit_id' => $deposit->id,
                    'balance_date' => $faker->date(),
                    'balance_amount' => $faker->randomFloat(2, 1000000, 10000000),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // Additional seeding for bond_holdings
        $bonds = DB::table('bonds')->get();
        foreach ($bonds as $bond) {
            for ($k = 0; $k < 3; $k++) {
                DB::table('bond_holdings')->insert([
                    'bond_id' => $bond->id,
                    'balance_date' => $faker->date(),
                    'units_held' => $faker->numberBetween(1, 100),
                    'book_value' => $faker->randomFloat(2, 1000000, 10000000),
                    'accrued_interest' => $faker->randomFloat(2, 0, 500000),
                    'fair_value' => $faker->randomFloat(2, 1000000, 10000000),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

    }
}
