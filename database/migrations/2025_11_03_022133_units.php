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
        Schema::create('unit_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('units')->noActionOnDelete();
            $table->foreignId('unit_type_id')->constrained('unit_types');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('cost_center_code')->nullable();
            $table->string('is_service_unit')->default('N');
            $table->string('is_active')->default('Y');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Examples of adding columns after table creation
        // Uncomment and modify as needed:
        
        // Schema::table('units', function (Blueprint $table) {
        //     // Add new columns
        //     $table->string('new_column')->nullable()->after('description');
        //     $table->integer('sort_order')->default(0);
        //     $table->boolean('is_department')->default(false);
        //     $table->decimal('budget', 15, 2)->nullable();
        //     $table->text('notes')->nullable();
        // });

        // Examples of renaming columns
        // Schema::table('units', function (Blueprint $table) {
        //     $table->renameColumn('old_column_name', 'new_column_name');
        // });

        // Examples of modifying column types
        // Schema::table('units', function (Blueprint $table) {
        //     $table->text('description')->nullable()->change(); // Change from string to text
        //     $table->string('name', 500)->change(); // Change length
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse any column additions/modifications first
        // Schema::table('units', function (Blueprint $table) {
        //     // Drop added columns
        //     $table->dropColumn(['new_column', 'sort_order', 'is_department', 'budget', 'notes']);
        //     
        //     // Reverse column renames
        //     $table->renameColumn('new_column_name', 'old_column_name');
        //     
        //     // Reverse column type changes
        //     $table->string('description')->nullable()->change();
        // });

        Schema::dropIfExists('units');
        Schema::dropIfExists('unit_types');
    }
};
