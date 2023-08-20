<?php

namespace App\Models;

use App\Models\Scopes\NotDepartedScope;
use Illuminate\Database\Eloquent\Builder;
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

    /**
     * - Global Scopes
     *
     * - Permiten agregar restricciones a todas las consultas para un modelo determinado.
     * - Es util cuando una consulta necesite siempre ejecutar cierta accion al utilizar all() o get().
     * - Para asignar un alcance global a un modelo, debe anular el booted método del modelo e invocar el addGlobalScopemétodo del modelo
     * - https://laravel.com/docs/10.x/eloquent#query-scopes
     */
    protected static function booted()
    {
        // Opción 1
        // static::addGlobalScope('not_departed', function (Builder $builder) {
        //     $builder->where('departed', false);
        // });

        // Opción 2 - Separar la logica en un archivo de scope.
        // static::addGlobalScope(new NotDepartedScope);
    }


    /**
     * Local Scopes
     *
     * - Los ámbitos locales le permiten definir conjuntos comunes de
     * restricciones de consulta que puede reutilizar fácilmente en toda su
     * aplicación. Por ejemplo, es posible que deba recuperar con frecuencia
     * todos los usuarios que se consideran "populares". Para definir un
     * alcance, prefije un método de modelo Eloquent con scope.
     * - https://laravel.com/docs/10.x/eloquent#query-scopes
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeLegs($query, $number)
    {
        return $query->where('legs', $number);
    }
}
