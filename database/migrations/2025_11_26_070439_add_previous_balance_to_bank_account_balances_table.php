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
        Schema::table('bank_account_balances', function (Blueprint $table) {
            $table->decimal('previous_balance', 15, 2)->default(0)->after('balance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_account_balances', function (Blueprint $table) {
            $table->dropColumn('previous_balance');
        });
    }
};
