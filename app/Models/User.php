<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'usuarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'rol',
        'dni',
        'nombre',
        'apellido',
        'email',
        'password',
        'password_cambiado',
        'autorizado_financiero',
        'estado',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'password_cambiado' => 'boolean',
            'autorizado_financiero' => 'boolean',
            'estado' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'usuario_id');
    }

    public function historialOperaciones()
    {
        return $this->hasMany(HistorialOperacion::class, 'usuario_id');
    }

    /**
     * Aplica filtro de busqueda en campos relevantes del usuario.
     */
    public function scopeBuscarParaGestion(Builder $query, string $busqueda): Builder
    {
        if ($busqueda === '') {
            return $query;
        }

        return $query->where(function (Builder $subQuery) use ($busqueda): void {
            $subQuery->where('nombre', 'like', '%' . $busqueda . '%')
                ->orWhere('apellido', 'like', '%' . $busqueda . '%')
                ->orWhere('email', 'like', '%' . $busqueda . '%')
                ->orWhere('dni', 'like', '%' . $busqueda . '%');
        });
    }

    /**
     * Orden estandar para listado de usuarios.
     */
    public function scopeOrdenadosPorNombre(Builder $query): Builder
    {
        return $query
            ->orderBy('apellido')
            ->orderBy('nombre');
    }

}
