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
        Schema::create('users', function (Blueprint $table){

            $table->id();
            $table->string('nombre_apellido');
            $table->integer('identificacion')->unique();
            $table->string('correo')->unique();
            $table->string('password');
            $table->string('telefono')->nullable();
            $table->string('genero')->nullable();
            $table->string('etnia')->nullable();   
            $table->string('discapacidad')->nullable();
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
