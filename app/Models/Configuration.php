<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = ['file_id'];

    // Relación de muchos a uno con File
    public function file()
    {
        return $this->belongsTo(File::class);
    }
}
