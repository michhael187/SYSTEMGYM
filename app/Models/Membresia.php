<?php

namespace App\Models;

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
}
