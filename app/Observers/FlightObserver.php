<?php

namespace App\Observers;

use App\Models\Flight;

class FlightObserver
{
    /**
     * NOTA: Los nombres de eventos que terminan en -ing se envían antes de que
     * se conserven los cambios en el modelo, mientras que los eventos que
     * terminan en -ed se envían después de que se conserven los cambios en el modelo.
     */

    /**
     * Handle the Flight "retrieved" event.
     * El evento retrieved se enviará cuando se recupere un modelo existente de la base de datos.
     */
    public function retrieved(Flight $flight): void
    {
        $flight->prueba = 'prueba';
    }

    /**
     * Handle the Flight "creating" event.
     * Se ejecuta antes de crear un registro en la db.
     */
    public function creating(Flight $flight): void
    {
        $flight->number = '12345';
    }

    /**
     * Handle the Flight "created" event.
     */
    public function created(Flight $flight): void
    {
        //
    }

    /**
     * Handle the Flight "updated" event.
     */
    public function updated(Flight $flight): void
    {
        //
    }

    /**
     * Handle the Flight "deleted" event.
     */
    public function deleted(Flight $flight): void
    {
        //
    }

    /**
     * Handle the Flight "restored" event.
     */
    public function restored(Flight $flight): void
    {
        //
    }

    /**
     * Handle the Flight "force deleted" event.
     */
    public function forceDeleted(Flight $flight): void
    {
        //
    }
}
