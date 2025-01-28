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
        Schema::create('reviciones', function (Blueprint $table) {
            $table->bigIncrements('id_revicion'); // ID primario
            $table->bigInteger('estudiante_id')->unsigned()->nullable(); // FK al estudiante
            $table->bigInteger('tutor_id')->unsigned()->nullable(); // FK al tutor
            $table->enum('estado_registro', ['inicializacion', 'en revision', 'aprobado'])->default('inicializacion'); // Estado del flujo
            $table->text('observaciones')->nullable(); // Observaciones del director o encargado
            $table->timestamp('fecha_revicion')->nullable(); // Fecha de última revisión
            $table->timestamps(); // Fechas de creación y actualización
            $table->softDeletes(); // Eliminación lógica

            // Relaciones
            $table->foreign('estudiante_id')->references('id_estudiante')->on('estudiantes')->onDelete('cascade')->nullable();
            $table->foreign('tutor_id')->references('id_tutor')->on('tutores')->onDelete('cascade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviciones');
    }
};
