<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class bank extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed bank accounts data here
        $faker = Faker::create();
        $bankAccounts = [
            ['account_number' => '1234567890', 'account_name' => 'Main Account', 'institution_code' => 'BKA', 'branch_code' => 'BKA001', 'account_type' => 'Checking', 'currency' => 'IDR', 'opened_date' => '2020-01-01'],
            ['account_number' => '0987654321', 'account_name' => 'Savings Account', 'institution_code' => 'CUB', 'branch_code' => 'CUB001', 'account_type' => 'Savings', 'currency' => 'IDR', 'opened_date' => '2021-06-15'],
        ];

        foreach ($bankAccounts as $account) {
            $institution = DB::table('financial_institutions')->where('code', $account['institution_code'])->first();
            $branch = DB::table('fi_branches')->where('code', $account['branch_code'])->first();

            if ($institution && $branch) {
                DB::table('bank_accounts')->insert([
                    'account_number' => $account['account_number'],
                    'account_name' => $account['account_name'],
                    'institution_id' => $institution->id,
                    'branch_id' => $branch->id,
                    'account_type' => $account['account_type'],
                    'currency' => $account['currency'],
                    'opened_date' => $account['opened_date'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        // Seed bank account balances data here
        $bankAccountBalances = [
            ['account_number' => '1234567890', 'balance_date' => '2023-12-31', 'balance_amount' => 10000000],
            ['account_number' => '0987654321', 'balance_date' => '2023-12-31', 'balance_amount' => 5000000],
        ];
        foreach ($bankAccountBalances as $balance) {
            $bankAccount = DB::table('bank_accounts')->where('account_number', $balance['account_number'])->first();

            if ($bankAccount) {
                DB::table('bank_account_balances')->insert([
                    'bank_account_id' => $bankAccount->id,
                    'balance_date' => $balance['balance_date'],
                    'balance_amount' => $balance['balance_amount'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
