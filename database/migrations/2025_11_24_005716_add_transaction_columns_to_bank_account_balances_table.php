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
            $table->decimal('in', 15, 2)->default(0)->after('balance_amount');
            $table->decimal('out', 15, 2)->default(0)->after('in');
            $table->decimal('masuk_pindah_buku', 15, 2)->default(0)->after('out');
            $table->decimal('keluar_pindah_buku', 15, 2)->default(0)->after('masuk_pindah_buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_account_balances', function (Blueprint $table) {
            $table->dropColumn(['in', 'out', 'masuk_pindah_buku', 'keluar_pindah_buku']);
        });
    }
};
