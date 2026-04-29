<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;
    // Datos base del personal que usa el sistema.
    protected $fillable = [
        'dni',
        'nombre',
        'apellido',
        'telefono',
        'membresia_actual_id',
        'fecha_ultimo_pago',
        'fecha_vencimiento',
        'peso',
        'altura',
        'observaciones',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'peso' => 'decimal:2',
            'altura' => 'decimal:2',
            'estado' => 'boolean',
            'fecha_ultimo_pago' => 'datetime',
            'fecha_vencimiento' => 'date',
            'deleted_at' => 'datetime',
        ];
    }
    // Estado actual del cliente para consulta operativa diaria.
    public function membresiaActual()
    {
        return $this->belongsTo(Membresia::class, 'membresia_actual_id');
    }
    // Historial de pagos del cliente. No representa el estado actual, sino cada transaccion registrada.
    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Aplica el filtro de busqueda segun el tipo y valor ingresado.
     */
    public function scopeBuscar(Builder $query, string $tipoBusqueda, string $valor): Builder
    {
        return match ($tipoBusqueda) {
            'dni' => $query->where('dni', (int) $valor),
            'apellido' => $query->where('apellido', 'like', '%' . $valor . '%'),
            default => $query,
        };
    }

    /**
     * Aplica el orden estandar utilizado en el listado de clientes.
     */
    public function scopeOrdenadosPorNombre(Builder $query): Builder
    {
        return $query
            ->orderBy('apellido')
            ->orderBy('nombre');
    }
}
