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
        Schema::create('estudiante_gestion', function (Blueprint $table) {
            $table->id('id_estudiante_gestion');
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('unidad_educativa_id');
            $table->unsignedBigInteger('gestion_id');
            $table->string('nivel')->default('INICIAL');
            $table->enum('curso', ['1', '2']);
            $table->string('paralelo');
            $table->integer('porcentaje_asistencia')->default(0);
            $table->timestamps();

            // Relaciones
            $table->foreign('estudiante_id')->references('id_estudiante')->on('estudiantes')->onDelete('cascade');
            $table->foreign('unidad_educativa_id')->references('id_unidad_educativa')->on('unidades_educativas')->onDelete('cascade');
            $table->foreign('gestion_id')->references('id_gestion')->on('gestiones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiante_gestion');
    }
};
