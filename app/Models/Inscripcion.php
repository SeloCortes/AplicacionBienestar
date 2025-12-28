<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Inscripcion extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'horario_id',
        'usuario_id',
        'fecha_inscripcion',
        'tipo_inscripcion',
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }

    public function horario(){
        return $this->belongsTo(Horario::class);
    }
}
