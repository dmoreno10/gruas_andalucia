<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Definir los campos que pueden ser asignados en masa
    protected $fillable = [
        'id',
        'user',
        'motive',
        'start_time',
        'title',
        'description',
        'start_time',
    ];

    // Opcionalmente puedes agregar otras configuraciones necesarias, como casts
    protected $casts = [
        'start_time' => 'datetime',
    ];
}
