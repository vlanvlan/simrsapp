<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;
use App\Models\FinancialInstitution;
use App\Models\FinancialBranch;

class BankAccountWithInstrumentTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some financial institutions and branches
        $institution = FinancialInstitution::first();
        $branch = FinancialBranch::first();

        if (!$institution || !$branch) {
            $this->command->warn('No financial institutions or branches found. Please run FinancialInstitution and Branch seeders first.');
            return;
        }

        // Sample bank accounts with different instrument types
        $bankAccounts = [
            [
                'account_name' => 'Main Current Account',
                'account_number' => 'CUR-001-2025',
                'institution_id' => $institution->id,
                'branch_id' => $branch->id,
                'account_type' => 'Business Current',
                'instrument_type' => 'current_account',
                'currency' => 'IDR',
                'opened_date' => '2025-01-01',
                'is_active' => true,
                'notes' => 'Primary current account for daily operations'
            ],
            [
                'account_name' => 'Emergency Savings',
                'account_number' => 'SAV-001-2025',
                'institution_id' => $institution->id,
                'branch_id' => $branch->id,
                'account_type' => 'High Interest Savings',
                'instrument_type' => 'savings',
                'currency' => 'IDR',
                'opened_date' => '2025-01-15',
                'is_active' => true,
                'notes' => 'Emergency fund savings account'
            ],
            [
                'account_name' => '6-Month Term Deposit',
                'account_number' => 'DEP-001-2025',
                'institution_id' => $institution->id,
                'branch_id' => $branch->id,
                'account_type' => 'Term Deposit',
                'instrument_type' => 'deposit',
                'currency' => 'IDR',
                'opened_date' => '2025-02-01',
                'is_active' => true,
                'notes' => '6-month fixed deposit with 6.5% interest'
            ],
            [
                'account_name' => '12-Month Term Deposit',
                'account_number' => 'DEP-002-2025',
                'institution_id' => $institution->id,
                'branch_id' => $branch->id,
                'account_type' => 'Term Deposit',
                'instrument_type' => 'deposit',
                'currency' => 'IDR',
                'opened_date' => '2025-03-01',
                'is_active' => true,
                'notes' => '12-month fixed deposit with 7.0% interest'
            ],
            [
                'account_name' => 'Government Bond Portfolio',
                'account_number' => 'BND-001-2025',
                'institution_id' => $institution->id,
                'branch_id' => $branch->id,
                'account_type' => 'Investment Account',
                'instrument_type' => 'bond',
                'currency' => 'IDR',
                'opened_date' => '2025-01-10',
                'is_active' => true,
                'notes' => 'Portfolio for government bond investments'
            ],
            [
                'account_name' => 'Money Market Fund',
                'account_number' => 'MMF-001-2025',
                'institution_id' => $institution->id,
                'branch_id' => $branch->id,
                'account_type' => 'Money Market',
                'instrument_type' => 'money_market',
                'currency' => 'IDR',
                'opened_date' => '2025-02-15',
                'is_active' => true,
                'notes' => 'Short-term money market investments'
            ]
        ];

        foreach ($bankAccounts as $account) {
            Bank::create($account);
            $this->command->info("Created bank account: {$account['account_name']} ({$account['instrument_type']})");
        }

        $this->command->info('Bank accounts with different instrument types seeded successfully!');
    }
}
