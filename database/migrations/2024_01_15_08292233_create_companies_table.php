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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id');
            $table->foreignId('country_id');
            $table->foreignId('city_id');
            $table->foreignId('company_size_id')->nullable();
            $table->foreignId('company_type_id')->nullable();
            $table->string('name')->nullable();
            $table->string('Working_days')->nullable();
            $table->string('Overtime_policy')->nullable();
            $table->string('webstie')->nullable();
            $table->string('facebook')->nullable();
            $table->string('logo')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
