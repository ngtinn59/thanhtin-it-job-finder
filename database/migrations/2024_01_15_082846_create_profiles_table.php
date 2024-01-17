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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->integer('users_id')->unsigned();
            $table->string('slug_title');
            $table->string('title');
            $table->string('image_url');
            $table->string('email');
            $table->string('phone_number');
            $table->boolean('gender');
            $table->date('date_of_birth');
            $table->string('address');
            $table->string('introduction');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
