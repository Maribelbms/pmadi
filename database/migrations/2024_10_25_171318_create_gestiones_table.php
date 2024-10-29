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
        Schema::create('gestiones', function (Blueprint $table) {
            $table->increments('id_gestion'); 
            $table->integer('nombre_gestion'); 
            $table->date('fecha_inicio'); 
            $table->date('fecha_fin'); 
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
        Schema::dropIfExists('gestiones');
    }
};
