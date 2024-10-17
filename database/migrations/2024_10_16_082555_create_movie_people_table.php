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
        Schema::create('movie_people', function (Blueprint $table) {
            $table->foreignId('person_id')->constrained('people','id')->onUpdate('cascade')->onDelete('no action');
            $table->foreignId('movie_id')->constrained('movies','id')->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['movie_id','person_id'],'movie_person_pk');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movie_people');
    }
};
