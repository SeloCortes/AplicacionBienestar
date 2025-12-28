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
        Schema::create('estudiantes', function (Blueprint $table){

            $table->id();
            $table->foreignId('usuario_id')->constrained()->cascadeOnDelete();
            $table->string('facultad');
            $table->string('nombre_carrera');
            $table->integer('semestre');
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
