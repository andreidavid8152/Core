<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UsuarioUpdated;
use App\Listeners\ActualizarVistasListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Asignación de eventos a sus listeners.
     *
     * @var array
     */
    protected $listen = [
        UsuarioUpdated::class => [
            ActualizarVistasListener::class,
        ],
    ];

    /**
     * Registrar cualquier servicio de eventos adicional.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
