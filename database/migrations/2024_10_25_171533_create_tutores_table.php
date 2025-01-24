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
        Schema::create('tutores', function (Blueprint $table) {
            $table->bigIncrements('id_tutor');
            $table->string('primer_nombre_tutor');
            $table->string('segundo_nombre_tutor')->nullable();
            $table->string('primer_apellido_tutor');
            $table->string('segundo_apellido_tutor')->nullable();
            $table->string('tercer_apellido_tutor')->nullable();
            $table->string('ci_tutor')->unique(); // Carnet de identidad único del tutor
            $table->string('expedido_tutor'); // Lugar de expedición del CI del tutor
            $table->bigInteger('gestion_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            // Relaciones
            $table->foreign('gestion_id')->references('id_gestion')->on('gestiones')->onDelete('cascade');
 

        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('tutores');
    }
};
