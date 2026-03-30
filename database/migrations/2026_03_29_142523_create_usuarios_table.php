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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->enum('rol', ['administrador', 'gerente', 'encargado'])->default('encargado');
            $table->integer('dni')->unique();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('password_cambiado')->default(false);
            $table->boolean('autorizado_financiero')->default(false);
            $table->boolean('estado')->default(true);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
