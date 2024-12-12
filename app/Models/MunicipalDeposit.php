<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MunicipalDeposit extends Model
{
    use HasFactory;
    protected $table = 'municipal_deposit';

    protected $fillable = ['name', 'direction', 'town', 'status', 'phone', 'mobile_phone'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
