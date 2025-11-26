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
            $table->foreignId('masuk_from_account_id')->nullable()->constrained('bank_accounts')->after('masuk_pindah_buku');
            $table->foreignId('keluar_to_account_id')->nullable()->constrained('bank_accounts')->after('keluar_pindah_buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bank_account_balances', function (Blueprint $table) {
            $table->dropForeign(['masuk_from_account_id']);
            $table->dropForeign(['keluar_to_account_id']);
            $table->dropColumn(['masuk_from_account_id', 'keluar_to_account_id']);
        });
    }
};
