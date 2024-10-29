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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id('id_estudiante', );
            $table->string('primer_nombre', 50);
            $table->string('segundo_nombre', 50)->nullable();
            $table->string('primer_apellido', 100);
            $table->string('segundo_apellido', 100)->nullable();
            $table->string('ci',30)->unique(); 
            $table->char('expedido', 2); 
            $table->enum('sexo', ['M', 'F']); // Género: M = Masculino, F = Femenino
            $table->string('rude',100)->unique(); 
            $table->string('nivel')->default('INICIAL'); 
            $table->enum('curso', ['1', '2']); 
            $table->string('paralelo'); // Paralelo (ej. A, B)
            $table->integer('porcentaje_asistencia')->default(0);
            $table->enum('habilitado', ['si', 'no']);
            $table->bigInteger('tutor_id')->unsigned()->nullable(); 
            $table->bigInteger('gestion_id')->unsigned(); 
            $table->timestamps(); 
            $table->softDeletes(); 

            // Relaciones
            $table->foreign('tutor_id')->references('id_tutor')->on('tutores')->onDelete('cascade');
            $table->foreign('gestion_id')->references('id_gestion')->on('gestiones')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};
