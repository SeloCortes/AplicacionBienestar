<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Administrativo extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'area',
        'rol',
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
