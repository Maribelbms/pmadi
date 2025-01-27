<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('profesores', function (Blueprint $table) {
            $table->unsignedBigInteger('unidad_educativa_id')->nullable()->after('user_id'); // Campo nuevo
            $table->foreign('unidad_educativa_id') // Clave foránea
                ->references('id_unidad_educativa') // Referencia al campo en `unidades_educativas`
                ->on('unidades_educativas')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profesores', function (Blueprint $table) {
            $table->dropForeign(['unidad_educativa_id']);
            $table->dropColumn('unidad_educativa_id');
        });
    }
};
