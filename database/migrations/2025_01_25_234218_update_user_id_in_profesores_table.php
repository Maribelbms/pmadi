<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('profesores', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable(false)->change(); // Asegurar que no sea nulo
    });
}

public function down()
{
    Schema::table('profesores', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->change();
    });
}

};
