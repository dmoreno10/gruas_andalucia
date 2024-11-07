<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'reservation_date',
        'status',
    ];

    // Opcional: Define relaciones, por ejemplo, si tienes un modelo User
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
}
