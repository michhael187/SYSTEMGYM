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
        Schema::table('registros_auditoria', function (Blueprint $table) {
            // 1. Eliminamos la FK de forma segura y genérica
            $table->dropForeign(['user_id']);
            
            // 2. Modificamos el campo para que sea nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // 3. Volvemos a añadir la FK
            $table->foreign('user_id')->references('id')->on('usuarios')->onDelete('restrict');

            // 4. Gestionamos la IP
            if (!Schema::hasColumn('registros_auditoria', 'direccion_ip')) {
                $table->string('direccion_ip', 45)->nullable()->after('valores_nuevos');
            } else {
                $table->string('direccion_ip', 45)->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registros_auditoria', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('usuarios')->onDelete('restrict');
            
            $table->string('direccion_ip', 45)->nullable(false)->change();
        });
    }
};