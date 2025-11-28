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
        // Table was already created with the correct name 'position_levels' in the original migration
        // No action needed
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No action needed as no rename was performed
    }
};
