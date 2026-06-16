<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE registros_auditoria DROP FOREIGN KEY registros_auditoria_user_id_foreign');
        DB::statement('ALTER TABLE registros_auditoria MODIFY user_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE registros_auditoria ADD CONSTRAINT registros_auditoria_user_id_foreign FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE RESTRICT');

        if (Schema::hasColumn('registros_auditoria', 'direccion_ip')) {
            DB::statement('ALTER TABLE registros_auditoria MODIFY direccion_ip VARCHAR(45) NULL');
        } else {
            Schema::table('registros_auditoria', function (Blueprint $table): void {
                $table->string('direccion_ip', 45)->nullable()->after('valores_nuevos');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE registros_auditoria DROP FOREIGN KEY registros_auditoria_user_id_foreign');
        DB::statement('ALTER TABLE registros_auditoria MODIFY user_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE registros_auditoria ADD CONSTRAINT registros_auditoria_user_id_foreign FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE RESTRICT');

        DB::statement('ALTER TABLE registros_auditoria MODIFY direccion_ip VARCHAR(45) NOT NULL');
    }
};
