<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','employee_id', 'start_time', 'end_at'];
    // Definir la relación con el empleado
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
