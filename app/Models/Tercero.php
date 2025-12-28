<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Tercero extends Model
{
    //
    use HasFactory;
    
    protected $fillable = [
        'usuario_id',
        'estamento',
    ];

    public function usuario(){
        return $this->belongsTo(User::class);
    }
}
