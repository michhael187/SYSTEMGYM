<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->index(['estado', 'fecha_vencimiento'], 'clientes_estado_fecha_vencimiento_idx');
            $table->index('fecha_vencimiento', 'clientes_fecha_vencimiento_idx');
            $table->index('membresia_actual_id', 'clientes_membresia_actual_idx');
        });

        Schema::table('pagos', function (Blueprint $table) {
            $table->index('fecha_pago', 'pagos_fecha_pago_idx');
            $table->index(['membresia_id', 'fecha_pago'], 'pagos_membresia_fecha_idx');
            $table->index(['cliente_id', 'fecha_pago'], 'pagos_cliente_fecha_idx');
        });

        Schema::table('membresias', function (Blueprint $table) {
            $table->index('activo', 'membresias_activo_idx');
            $table->index('nombre_plan', 'membresias_nombre_plan_idx');
        });

        Schema::table('usuarios', function (Blueprint $table) {
            $table->index(['rol', 'estado'], 'usuarios_rol_estado_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropIndex('usuarios_rol_estado_idx');
        });

        Schema::table('membresias', function (Blueprint $table) {
            $table->dropIndex('membresias_nombre_plan_idx');
            $table->dropIndex('membresias_activo_idx');
        });

        Schema::table('pagos', function (Blueprint $table) {
            $table->dropIndex('pagos_cliente_fecha_idx');
            $table->dropIndex('pagos_membresia_fecha_idx');
            $table->dropIndex('pagos_fecha_pago_idx');
        });

        Schema::table('clientes', function (Blueprint $table) {
            $table->dropIndex('clientes_membresia_actual_idx');
            $table->dropIndex('clientes_fecha_vencimiento_idx');
            $table->dropIndex('clientes_estado_fecha_vencimiento_idx');
        });
    }
};
