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
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropUnique(['code']); // Drop existing unique constraint
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->string('code')->nullable()->change(); // Make nullable
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->unique('code'); // Add unique constraint back
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropUnique(['code']);
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->string('code')->nullable(false)->change();
        });

        Schema::table('deposits', function (Blueprint $table) {
            $table->unique('code');
        });
    }
};
