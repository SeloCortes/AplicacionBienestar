<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo_curso',
        'descripcion',
        'imagen',
        'estado',
    ];

    public function horarios(){
        return $this->hasMany(Horario::class);
    }
}
