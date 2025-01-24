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
        
            Schema::create('profesor_unidad', function (Blueprint $table) {
                $table->id();
                $table->foreignId('profesor_id')->constrained('profesores')->onDelete('cascade'); // Relación con profesores
                $table->foreignId('unidad_educativa_id')->constrained('unidades_educativas', 'id_unidad_educativa')->onDelete('cascade'); // Relación con unidades educativas
                $table->string('nivel'); // Nivel educativo (Ej: Inicial, Primaria, Secundaria)
                $table->string('curso'); // Curso específico (Ej: 1°, 2°, 3°)
                $table->string('paralelo'); // Paralelo asignado (Ej: A, B, C)
                $table->boolean('activo')->default(true); // Indica si la relación está activa
                $table->timestamps();
            });
            
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profesor_unidad');
    }
};
