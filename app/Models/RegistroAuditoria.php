<?php

namespace App\Models;

use App\Enums\AccionAuditoria;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use RuntimeException;

class RegistroAuditoria extends Model
{
    protected $table = 'registros_auditoria';

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'auditable_type',
        'auditable_id',
        'accion',
        'modulo',
        'valores_viejos',
        'valores_nuevos',
        'direccion_ip',
    ];

    protected function casts(): array
    {
        return [
            'accion' => AccionAuditoria::class,
            'valores_viejos' => 'array',
            'valores_nuevos' => 'array',
            'created_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::updating(function (): bool {
            throw new RuntimeException('Los registros de auditoría son inmutables y no pueden modificarse.');
        });

        static::deleting(function (): bool {
            throw new RuntimeException('Los registros de auditoría son inmutables y no pueden eliminarse.');
        });
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    public function moduloEtiqueta(): string
    {
        return match ($this->modulo) {
            'usuarios' => 'Usuarios',
            'clientes' => 'Clientes',
            'membresias' => 'Membresías',
            'pagos' => 'Pagos',
            'autenticacion' => 'Autenticación',
            'documentos' => 'Documentos',
            default => ucfirst($this->modulo),
        };
    }
}
