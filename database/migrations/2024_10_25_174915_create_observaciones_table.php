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
        Schema::create('observaciones', function (Blueprint $table) {
            $table->bigIncrements('id_observacion');
            $table->enum('tipo_observacion', ['inicial', 'seguimiento', 'final']); 
            $table->text('descripcion'); 
            $table->datetime('fecha_observacion'); 
            $table->bigInteger('persona_id')->unsigned(); 
            $table->bigInteger('usuario_id')->unsigned(); 
            $table->bigInteger('gestion_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            // Definir las claves foráneas
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('gestion_id')->references('id_gestion')->on('gestiones')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('observaciones');
    }
};
