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
            $table->string('hora_inicio', 5);
            $table->string('hora_fin', 5);
            $table->string('profesor');
            $table->string('salon', 100)->nullable();
            $table->integer('cupo_maximo_estudiante');
            $table->integer('cupo_disponible_estudiante');
            $table->integer('cupo_maximo_tercero');
            $table->integer('cupo_disponible_tercero');
            $table->boolean('activo')->default(true);
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
