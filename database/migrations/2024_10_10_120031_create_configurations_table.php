<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configuracions', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable(); // Logo de la aplicación
            $table->string('user_image')->nullable(); // Imagen del usuario
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuracions');
    }
};
