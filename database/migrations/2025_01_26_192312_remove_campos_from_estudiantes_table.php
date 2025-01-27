<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->dropColumn(['nivel', 'curso', 'paralelo', 'porcentaje_asistencia', 'unidad_educativa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->string('nivel')->default('INICIAL');
            $table->enum('curso', ['1', '2']);
            $table->string('paralelo');
            $table->integer('porcentaje_asistencia')->default(0);

            $table->foreign('unidad_educativa_id')->references('id_unidad_educativa')->on('unidades_educativas')->onDelete('cascade');
        });
    }
};
