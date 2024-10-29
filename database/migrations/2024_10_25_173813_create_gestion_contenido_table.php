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
        Schema::create('gestion_contenido', function (Blueprint $table) {
            $table->id('id_gestion');
            $table->string('titulo', 100);
            $table->string('descripcion', 200);
            $table->string('imagen', 100)->nullable();
            $table->string('url', 100)->nullable();
            $table->enum('tipo', ['anuncio', 'noticia', 'imagen','video','contacto','ubicacion']);
            $table->timestamps();
            $table->softDeletes();

            

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_contenido');
    }
};
