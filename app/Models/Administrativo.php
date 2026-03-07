<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrativo extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'area',
        'rol',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'usuario_id');
    }
}
