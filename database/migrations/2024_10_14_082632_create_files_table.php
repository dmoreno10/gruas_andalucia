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
        Schema::create('files', function (Blueprint $table) {
            $table->id();  // La clave primaria
            $table->string('filename');  // Nombre del archivo
            $table->timestamps();  // Fechas de creación y actualización
        });
    }

    public function down()
    {
        Schema::dropIfExists('files');
    }
};
