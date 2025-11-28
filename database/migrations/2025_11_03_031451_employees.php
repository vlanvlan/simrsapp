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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_code')->unique();
            $table->string('name');
            $table->foreignId('position_id')->constrained('positions');
            $table->foreignId('unit_id')->constrained('units');
            $table->string('employment_status')->default('permanent');
            $table->date('hire_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('nik')->nullable();
            $table->string('npwp')->nullable();
            $table->string('gender')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->foreignId('supervisor_id')->nullable()->constrained('employees')->noActionOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
