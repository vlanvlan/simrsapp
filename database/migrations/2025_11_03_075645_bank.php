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
        // Bank Account related migrations can be added here
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->unique();
            $table->string('account_name');
            $table->foreignId('institution_id')->constrained('financial_institutions');
            $table->foreignId('branch_id')->constrained('fi_branches');
            $table->string('account_type')->nullable();
            $table->string('currency')->default('IDR');
            $table->date('opened_date')->nullable();
            $table->date('closed_date')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Input saldo periodik migrations can be added here
        Schema::create('bank_account_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_account_id')->constrained('bank_accounts');
            $table->date('balance_date');
            $table->decimal('balance_amount', 15, 2);
            $table->string('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('bank_account_balances');
    }
};
