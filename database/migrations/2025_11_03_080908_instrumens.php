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
        // ========= INSTRUMEN GENERIK (SUPER-TIPE UNTUK DEPOSITO/OBLIGASI) =========
        Schema::create('instrumens', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); // e.g., 'deposit', 'bond', etc.
            $table->foreignId('institution_id')->constrained('financial_institutions');
            $table->foreignId('branch_id')->constrained('fi_branches');
            $table->string('currency')->default('IDR');
            $table->timestamps();
            $table->softDeletes();
        });

        // ------- DEPOSITO (BILYET) -------
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrumen_id')->constrained('instrumens');
            $table->string('deposit_number')->unique();
            $table->date('start_date');
            $table->date('maturity_date');
            $table->decimal('principal_amount', 15, 2);
            $table->decimal('interest_rate', 5, 2); // e.g., 5.25%
            $table->string('interest_payment_frequency')->nullable(); // e.g., 'monthly', 'quarterly'
            $table->string('status')->default('active'); // e.g., 'active', 'matured', 'closed'
            $table->timestamps();
            $table->softDeletes();
        });

        // Snapshot nilai pada tanggal (untuk laporan saldo portofolio)
        Schema::create('deposit_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('deposit_id')->constrained('deposits');
            $table->date('balance_date');
            $table->decimal('balance_amount', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });

        // ------- OBLIGASI (SERI) -------
        Schema::create('bonds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instrumen_id')->constrained('instrumens');
            $table->string('bond_series')->unique();
            $table->date('issue_date');
            $table->date('maturity_date');
            $table->decimal('face_value', 15, 2);
            $table->decimal('coupon_rate', 5, 2); // e.g., 6.50%
            $table->string('coupon_payment_frequency')->nullable(); // e.g., 'semi-annual', 'annual'
            $table->string('status')->default('active'); // e.g., 'active', 'matured', 'redeemed'
            $table->timestamps();
            $table->softDeletes();
        });

        // Snapshot nilai kepemilikan obligasi per tanggal
        Schema::create('bond_holdings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bond_id')->constrained('bonds');
            $table->date('balance_date');
            $table->string('units_held');
            $table->decimal('book_value', 15, 2);
            $table->decimal('accrued_interest', 15, 2)->default(0);
            $table->decimal('fair_value', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bond_holdings');
        Schema::dropIfExists('bonds');
        Schema::dropIfExists('deposit_balances');
        Schema::dropIfExists('deposits');
        Schema::dropIfExists('instrumens');
    }
};
