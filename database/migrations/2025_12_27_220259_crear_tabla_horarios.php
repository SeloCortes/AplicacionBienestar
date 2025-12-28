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

        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained()->cascadeOnDelete();
            $table->enum('dia', ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado']);
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('profesor');
            $table->integer('cupo_maximo');
            $table->integer('cupo_disponible');
            $table->boolean('estado')->default(true);
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
