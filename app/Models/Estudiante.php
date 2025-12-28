<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    
}
