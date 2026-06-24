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
        //
        Schema::create("administrativos", function (Blueprint $table) {

            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->enum('area', ['Deporte formativo', 'Arte y cultura', 'Catedra Santiaguina', 'Bienestar Universitario', 'Sistemas']);
            $table->string('rol');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
