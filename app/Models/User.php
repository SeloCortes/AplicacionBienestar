<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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


    protected $hidden = [ 'contrasena', ];


    //relaciones

    public function estuadiante(){
        return $this->hasOne(Estudiante::class);
    }

    public function administrativo(){
        return $this->hasOne(Administrativo::class);
    }

    public function tercero(){
        return $this->hasOne(Tercero::class);
    }

    public function inscripciones(){
        return $this->hasMany(Inscripcion::class);
    }
}
