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
            $table->foreignId('location_id');
            $table->foreignId('skillscompanies_id');

            $table->string('title');
            $table->string('url_tilte');
            $table->string('company_size');
            $table->string('company_type');
            $table->string('Working_days');
            $table->string('Overtime_policy');

            $table->string('webstie')->nullable();
            $table->string('facebook')->nullable();
            $table->string('logo')->nullable();
            $table->string('address');
            $table->string('description');
            $table->timestamps();
//            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
//            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
//            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
//            $table->foreign('skillscompanies_id')->references('id')->on('skill_companies')->onDelete('cascade');
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
