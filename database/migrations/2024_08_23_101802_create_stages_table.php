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
        Schema::create('stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('travel_id');
            $table->string('place', 150);
            $table->string('slug', 150);
            $table->string('day', 15);
            $table->text('note', 250)->nullable();
            $table->string('photo', 255)->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('travel_id')->references('id')->on('travels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stages');
    }
};
