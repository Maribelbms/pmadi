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
        Schema::create('docente_curso', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned(); // ID del docente
            $table->bigInteger('unidad_educativa_id')->unsigned(); // ID de la unidad educativa
            $table->string('nivel'); // Inicial, Primaria, Secundaria
            $table->string('curso'); // Ejemplo: 1, 2, 3, etc.
            $table->string('paralelo'); // Ejemplo: A, B, C, etc.
            $table->timestamps();

            // Relaciones
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('unidad_educativa_id')->references('id_unidad_educativa')->on('unidades_educativas')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docente_curso');
    }
};
