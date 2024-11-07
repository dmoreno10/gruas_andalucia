<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Incident;

class IncidentUpdated
{
    use Dispatchable, SerializesModels;

    public $incident;

    /**
     * Create a new event instance.
     *
     * @param Incident $incident
     */
    public function __construct(Incident $incident)
    {
        $this->incident = $incident;
    }
}
