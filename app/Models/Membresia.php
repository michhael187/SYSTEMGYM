<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membresia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nombre_plan',
        'precio',
        'duracion_dias',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'duracion_dias' => 'integer',
            'activo' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    public function clientesActuales()
    {
        return $this->hasMany(Cliente::class, 'membresia_actual_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }

    /**
     * Aplica filtro por nombre del plan cuando corresponde.
     */
    public function scopeBuscarPorNombrePlan(Builder $query, string $busqueda): Builder
    {
        if ($busqueda === '') {
            return $query;
        }

        return $query->where('nombre_plan', 'like', '%' . $busqueda . '%');
    }

    /**
     * Filtra por estado del plan en el listado de gestion.
     */
    public function scopeFiltrarPorEstado(Builder $query, string $estado): Builder
    {
        return match ($estado) {
            'activas' => $query->where('activo', true),
            'inactivas' => $query->where('activo', false),
            default => $query,
        };
    }

    /**
     * Orden estandar para mostrar planes en pantalla.
     */
    public function scopeOrdenadasPorNombre(Builder $query): Builder
    {
        return $query->orderBy('nombre_plan');
    }
}
