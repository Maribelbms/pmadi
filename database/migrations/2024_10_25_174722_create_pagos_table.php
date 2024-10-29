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
        Schema::create('pagos', function (Blueprint $table) {
            $table->bigIncrements('id_pago');
            $table->bigInteger('estudiante_id')->unsigned(); 
            $table->bigInteger('tutor_id')->unsigned(); 
            $table->bigInteger('unidad_educativa_id')->unsigned(); 
            $table->bigInteger('gestion_id')->unsigned(); 
            $table->decimal('monto_bono', 8, 2); 
            $table->date('fecha'); 
            $table->bigInteger('estado_id')->unsigned(); 
            $table->softDeletes();
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('estudiante_id')->references('id_estudiante')->on('estudiantes')->onDelete('cascade');
            $table->foreign('tutor_id')->references('id_tutor')->on('tutores')->onDelete('cascade');
            $table->foreign('unidad_educativa_id')->references('id_unidad_educativa')->on('unidades_educativas')->onDelete('cascade');
            $table->foreign('gestion_id')->references('id_gestion')->on('gestiones')->onDelete('cascade');
            $table->foreign('estado_id')->references('id_estado')->on('estados_pago')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
