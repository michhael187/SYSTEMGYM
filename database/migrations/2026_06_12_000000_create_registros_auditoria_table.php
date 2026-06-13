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
        Schema::create('registros_auditoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('usuarios')->restrictOnDelete();
            $table->nullableMorphs('auditable');
            $table->string('accion');
            $table->string('modulo');
            $table->json('valores_viejos')->nullable();
            $table->json('valores_nuevos')->nullable();
            $table->string('direccion_ip', 45);
            $table->timestamp('created_at')->useCurrent();

            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_auditoria');
    }
};
