<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Horario extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'dia',
        'hora_inicio',
        'hora_fin',
        'profesor',
        'salon',
        'cupo_maximo_estudiante',
        'cupo_disponible_estudiante',
        'cupo_maximo_tercero',
        'cupo_disponible_tercero',
        'activo',
    ];

    public function curso(){
        return $this->belongsTo(Curso::class, 'curso_id');
    }

    public function inscripciones(){
        return $this->hasMany(Inscripcion::class);
    }

}
