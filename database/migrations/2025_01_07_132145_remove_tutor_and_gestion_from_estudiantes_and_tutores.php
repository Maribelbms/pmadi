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
        Schema::table('estudiantes', function (Blueprint $table) {
            if (Schema::hasColumn('estudiantes', 'tutor_id')) {
                $table->dropForeign(['tutor_id']); // Eliminamos la clave foránea
                $table->dropColumn('tutor_id'); // Eliminamos el campo tutor_id
            }

            if (Schema::hasColumn('estudiantes', 'gestion_id')) {
                $table->dropForeign(['gestion_id']); // Eliminamos la clave foránea
                $table->dropColumn('gestion_id'); // Eliminamos el campo gestion_id
            }
        });

        Schema::table('tutores', function (Blueprint $table) {
            if (Schema::hasColumn('tutores', 'gestion_id')) {
                $table->dropForeign(['gestion_id']); // Eliminamos la clave foránea
                $table->dropColumn('gestion_id'); // Eliminamos el campo gestion_id
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estudiantes', function (Blueprint $table) {
            $table->bigInteger('tutor_id')->unsigned()->nullable();
            $table->foreign('tutor_id')->references('id_tutor')->on('tutores')->onDelete('cascade');

            $table->bigInteger('gestion_id')->unsigned()->nullable();
            $table->foreign('gestion_id')->references('id_gestion')->on('gestiones')->onDelete('cascade');
        });

        Schema::table('tutores', function (Blueprint $table) {
            $table->bigInteger('gestion_id')->unsigned()->nullable();
            $table->foreign('gestion_id')->references('id_gestion')->on('gestiones')->onDelete('cascade');
        });
    }
};
