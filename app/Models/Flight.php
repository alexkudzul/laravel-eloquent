<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flight extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Prunable;

    protected $guarded = [];

    /**
     * - prunable() Elimine todos los modelos de la base de datos.
     * - Se elimina cada vez que se ejecute el siguiente comando:
     * php artisan model:prune
     * - La idea es que se ejecute cada cierto tiempo y no hacerlo manual para eso
     * agregar el siguiente codigo $schedule->command('model:prune')->daily();
     * en app/Console/Kernel.php. El codigo anterior se ejecuta cada día y
     * para que funcione en el servidor se necesita un cron job.
     */
    public function prunable()
    {
        return static::where('departed', true);
    }

    /**
     * - pruning() Preparar el modelo antes de eliminar
     * - Se ejecuta antes de prunable().
     */
    public function pruning()
    {
        // Eliminar los archivos asociados al registro
        // Storage::delete($this->image_url);
    }
}
