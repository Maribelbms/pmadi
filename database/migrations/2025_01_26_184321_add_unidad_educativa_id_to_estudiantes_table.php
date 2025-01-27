<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('estudiantes', function (Blueprint $table) {
        $table->unsignedBigInteger('unidad_educativa_id')->nullable();
        $table->foreign('unidad_educativa_id')->references('id_unidad_educativa')->on('unidades_educativas')->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            //
        });
    }
};
