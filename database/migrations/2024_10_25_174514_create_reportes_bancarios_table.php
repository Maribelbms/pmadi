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
        Schema::create('reportes_bancarios', function (Blueprint $table) {
            $table->bigIncrements('id_reporte'); 
            $table->dateTime('fecha_carga'); 
            $table->string('descripcion', 200);
            $table->bigInteger('usuario_id')->unsigned(); 
            $table->integer('gestion_id')->unsigned(); 
            $table->timestamps(); 
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gestion_id')->references('id_gestion')->on('gestiones')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reportes_bancarios');
    }
};
