<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'tipo_curso',
        'descripcion',
        'imagen',
        'activo',
    ];

    public function horarios(){
        return $this->hasMany(Horario::class);
    }
}
