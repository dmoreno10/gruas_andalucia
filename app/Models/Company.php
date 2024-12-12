<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

       // Especificamos los campos que son asignables
       protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
    ];


}
