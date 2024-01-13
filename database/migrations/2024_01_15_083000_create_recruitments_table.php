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
        Schema::create('recruitments', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->integer('company_id')->unsigned();

            $table->string('title');
            $table->string('slug_title');
            $table->string('position');
            $table->string('form_of_work');
            $table->string('experience_level');
            $table->string('skills_required');
            $table->string('experience_details');
            $table->integer('quantity');
            $table->float('min_salary');
            $table->float('max_salary');
            $table->date('expiration_date');
            $table->string('address_work');
            $table->string('job_description');
            $table->string('job_requirements');
            $table->string('benefits');
            $table->integer('recruitment_status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitments');
    }
};
