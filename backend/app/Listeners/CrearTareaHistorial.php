<?php

namespace App\Listeners;

use App\Events\ReparacionResolved;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CrearTareaHistorial
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
    public function handle(ReparacionResolved  $event)
    {
        \App\Models\Tarea::create([
            'descripcion' => "Reparación #{$event->reparacion->id} resuelta",
            'fecha_creada' => now(),
            'fecha_limite' => now(),
            'id_empleado' => $event->reparacion->id_empleado,
            'id_estado' => 8, // completada
        ]);
    }
}
