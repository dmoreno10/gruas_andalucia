<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['total_points', 'name', 'email', 'position', 'department','company_id', 'status', 'user_id'];

    // Definir la relación con el tiempo de entrada (opcional)
    public function timeEntries()
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class); // Establecemos la relación "pertenece a"
    }
}
