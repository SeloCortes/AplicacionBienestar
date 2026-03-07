<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    //
    use HasFactory;

    protected $fillable = [
        'nombre_apellido',
        'identificacion',
        'correo',
        'password',
        'telefono',
        'genero',
        'etnia',
        'discapacidad',
    ];

    protected $hidden = ['password'];

    // relaciones

    public function estudiante()
    {
        return $this->hasOne(Estudiante::class , 'usuario_id');
    }

    public function administrativo()
    {
        return $this->hasOne(Administrativo::class , 'usuario_id');
    }

    public function tercero()
    {
        return $this->hasOne(Tercero::class , 'usuario_id');
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }
}
