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

    public function user(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function horario(){
        return $this->belongsTo(Horario::class, 'horario_id');
    }
}
