<?php

namespace App\Listeners;

use App\Events\UsuarioUpdated;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Broadcast;

class ActualizarVistasListener
{
    /**
     * Maneja el evento UsuarioUpdated.
     *
     * @param UsuarioUpdated $event
     * @return void
     */
    public function handle(UsuarioUpdated $event)
    {
        // Notificar a las vistas sobre los cambios realizados
        Broadcast::channel('usuario-updated', function () use ($event) {
            return [
                'id' => $event->usuario->id,
                'nombre' => $event->usuario->nombre,
                'preferencias' => $event->usuario->preferencias,
                'restricciones' => $event->usuario->restricciones,
            ];
        });

        Log::info('Usuario actualizado:', [
            'id' => $event->usuario->id,
            'nombre' => $event->usuario->nombre,
        ]);
    }
}
