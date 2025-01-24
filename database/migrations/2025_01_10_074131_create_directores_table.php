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
        Schema::create('directores', function (Blueprint $table) {
            $table->id(); // Identificador único
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Relación con usuarios
            $table->string('ci')->unique(); // Cédula de identidad única
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->string('email')->unique(); // Correo único
            $table->string('telefono')->nullable();
            $table->foreignId('unidad_educativa_id')->constrained('unidades_educativas', 'id_unidad_educativa')->onDelete('cascade'); // Relación con unidad educativa
            $table->boolean('activo')->default(true); // Estado del director
            $table->timestamps(); // Fechas de creación y modificación
    
        });
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directores');
    }
};
