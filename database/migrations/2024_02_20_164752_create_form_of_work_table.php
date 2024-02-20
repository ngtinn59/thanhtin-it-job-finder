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
        Schema::create('form_of_work', function (Blueprint $table) {
            $table->id();
            $table->string("name",70)->nullable();
            $table->unsignedBigInteger('recruitments_id');
            $table->foreign('recruitments_id')->references('id')->on('recruitments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_of_work');
    }
};
