<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'status',
    ];

    /**
     * Relación con el modelo User.
     *
     * Obtén el usuario asociado con el log de acceso.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
