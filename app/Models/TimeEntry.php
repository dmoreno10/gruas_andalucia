<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $fillable = ['user_id','employee_id', 'start_time', 'ended_at','end_time'];
    protected $dates = ['start_time', 'end_time'];
    public $timestamps = false;

    // Definir la relación con el empleado
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
