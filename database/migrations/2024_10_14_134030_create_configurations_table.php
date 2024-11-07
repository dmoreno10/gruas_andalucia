<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable(); // Logo de la aplicación
            $table->string('user_image')->nullable(); // Imagen del usuario
            $table->foreignId('file_id')->nullable()->constrained('files')->onDelete('cascade'); // Relación con la tabla de archivos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configurations'); // Asegúrate de que el nombre sea correcto
    }
};
