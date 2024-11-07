<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];
    public function configuration()
    {
        return $this->hasOne(Configuration::class);
    }
    // App/Models/File.php
      public function documentalGestion()
    {
        return $this->hasOne(DocumentalGestion::class); // Ajusta esto si es necesario
    }

}
