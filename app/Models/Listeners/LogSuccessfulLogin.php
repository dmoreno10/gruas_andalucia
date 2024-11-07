<?php

namespace App\Listeners;

use App\Models\AccessLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        AccessLog::create([
            'user_id' => $event->user->id,  // Guarda el ID del usuario que se ha autenticado
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => 'success',  // Establecer el estado de éxito
        ]);
    }
}
