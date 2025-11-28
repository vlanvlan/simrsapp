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
        // Check if the code column exists
        $columnExists = Schema::hasColumn('deposits', 'code');

        if ($columnExists) {
            // Check if unique constraint exists before dropping it
            $constraintExists = \DB::select("
                SELECT COUNT(*) as count
                FROM sys.indexes
                WHERE object_id = OBJECT_ID('deposits')
                AND name = 'deposits_code_unique'
            ");

            if ($constraintExists[0]->count > 0) {
                Schema::table('deposits', function (Blueprint $table) {
                    $table->dropUnique(['code']); // Drop existing unique constraint
                });
            }

            Schema::table('deposits', function (Blueprint $table) {
                $table->string('code')->nullable()->change(); // Make nullable
            });

            Schema::table('deposits', function (Blueprint $table) {
                $table->unique('code'); // Add unique constraint back
            });
        } else {
            // Column doesn't exist, add it as nullable with unique constraint
            Schema::table('deposits', function (Blueprint $table) {
                $table->string('code')->nullable()->unique();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Check if the code column exists
        $columnExists = Schema::hasColumn('deposits', 'code');

        if ($columnExists) {
            // Check if unique constraint exists before dropping it
            $constraintExists = \DB::select("
                SELECT COUNT(*) as count
                FROM sys.indexes
                WHERE object_id = OBJECT_ID('deposits')
                AND name = 'deposits_code_unique'
            ");

            if ($constraintExists[0]->count > 0) {
                Schema::table('deposits', function (Blueprint $table) {
                    $table->dropUnique(['code']);
                });
            }

            Schema::table('deposits', function (Blueprint $table) {
                $table->string('code')->nullable(false)->change();
            });

            Schema::table('deposits', function (Blueprint $table) {
                $table->unique('code');
            });
        }
    }
};
