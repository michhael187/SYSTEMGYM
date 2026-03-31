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
            $table->foreignId('membresia_actual_id')
                ->nullable()
                ->after('telefono')
                ->constrained('membresias')
                ->nullOnDelete();

            $table->timestamp('fecha_ultimo_pago')
                ->nullable()
                ->after('membresia_actual_id');

            $table->date('fecha_vencimiento')
                ->nullable()
                ->after('fecha_ultimo_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropForeign(['membresia_actual_id']);
            $table->dropColumn([
                'membresia_actual_id',
                'fecha_ultimo_pago',
                'fecha_vencimiento',
            ]);
        });
    }
};
