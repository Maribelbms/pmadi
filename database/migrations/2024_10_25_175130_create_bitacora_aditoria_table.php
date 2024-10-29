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
        Schema::create('bitacora_aditoria', function (Blueprint $table) {
            $table->bigIncrements('id_bitacora'); 
            $table->bigInteger('usuario_id')->unsigned(); 
            $table->string('tabla_afectada', 100); 
            $table->bigInteger('id_registro_afectado')->unsigned(); 
            $table->string('accion_realizada', 50); 
            $table->dateTime('fecha'); 
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable(); 
            $table->string('ip', 45); 
            $table->string('navegador', 200);
            $table->timestamps(); 

            // Definir las claves foráneas
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bitacora_aditoria');
    }
};
