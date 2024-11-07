<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'points',
        'description',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
