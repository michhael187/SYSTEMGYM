<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory, SoftDeletes;

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

    public function membresiaActual()
    {
        return $this->belongsTo(Membresia::class, 'membresia_actual_id');
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class);
    }
}
