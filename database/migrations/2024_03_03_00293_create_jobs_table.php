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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('jobtype_id');
            $table->unsignedBigInteger('city_id');

            $table->string('title');
            $table->float('salary');
            $table->string('skills');
            $table->integer('status');
            $table->integer('featured');
            $table->string('address');
            $table->string('description');
            $table->text('skill_experience');
            $table->text('benefits');
            $table->date('last_date');
            $table->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('jobtype_id')->references('id')->on('job_types')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
