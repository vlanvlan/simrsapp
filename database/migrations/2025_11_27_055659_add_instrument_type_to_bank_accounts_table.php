<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->enum('instrument_type', ['current_account', 'savings', 'deposit', 'bond', 'money_market'])
                  ->default('current_account')
                  ->after('account_type')
                  ->comment('Type of financial instrument: current_account, savings, deposit, bond, money_market');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_accounts', function (Blueprint $table) {
            $table->dropColumn('instrument_type');
        });
    }
};
