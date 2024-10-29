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
        Schema::create('unidades_educativas', function (Blueprint $table) {
            $table->bigIncrements('id_unidad_educativa');
            $table->string('nombre_unidad', 100); 
            $table->string('codigo_sie', 100); 
            $table->enum('turno', ['mañana', 'tarde', 'noche']);
            $table->enum('distrital_educacion', ['el alto1', 'el alto2', 'el alto3']); 
            $table->integer('distrito'); 
            $table->string('direccion', 300); 
            $table->enum('estado', ['Activa', 'Inactiva']);
            $table->timestamps(); 
            $table->softDeletes(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_educativas');
    }
};
