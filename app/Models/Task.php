<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    use HasFactory;

    protected $fillable = [ 'description', 'points', 'employee_id','time_minutes'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
