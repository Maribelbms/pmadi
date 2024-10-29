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
        Schema::create('reviciones', function (Blueprint $table) {
            $table->bigIncrements('id_revicion');
            $table->bigInteger('estudiante_id')->unsigned()->nullable(); 
            $table->bigInteger('tutor_id')->unsigned()->nullable(); 
            $table->enum('estado_registro', ['en revision', 'aprobado', 'con observaciones'])->default('en revision');
            $table->text('observaciones')->nullable(); 
            $table->bigInteger('usuario_id')->unsigned(); 
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('estudiante_id')->references('id_estudiante')->on('estudiantes')->onDelete('cascade')->nullable(); // FK al estudiante (opcional)
            $table->foreign('tutor_id')->references('id_tutor')->on('tutores')->onDelete('cascade')->nullable(); // FK al tutor (opcional)
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviciones');
    }
};
