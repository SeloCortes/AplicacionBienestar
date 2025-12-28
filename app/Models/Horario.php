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
        'cupo_maximo',
        'cupo_disponible',
        'estado',
    ];

    public function curso(){
        return $this->belongsTo(Curso::class);
    }

    public function inscripciones(){
        return $this->hasMany(Inscripcion::class);
    }

}
