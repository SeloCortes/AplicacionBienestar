<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tercero extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'estamento',
    ];

    public function user()
    {
        return $this->belongsTo(User::class , 'usuario_id');
    }
}
