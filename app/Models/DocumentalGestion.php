<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentalGestion extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'documental_gestion';

    // Campos asignables en masa
    protected $fillable = [
        'title', 'description', 'file_name', 'file_path', 'file_size', 'mime_type',
        'upload_date', 'user_id', 'status', 'tags', 'is_public', 'password_protected', 'password'
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class); // Relación con la tabla 'users'
    }
}
