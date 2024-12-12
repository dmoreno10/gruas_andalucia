<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = ['id', 'brand', 'model', 'year', 'type', 'color', 'status', 'photo', 'license_plate', 'created_at', 'updated_at'];
    public function municipalDeposit()
    {
        return $this->belongsTo(MunicipalDeposit::class);
    }

    use HasFactory;
}
