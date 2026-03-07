<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'facultad',
        'nombre_carrera',
        'semestre',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'usuario_id');
    }
}
