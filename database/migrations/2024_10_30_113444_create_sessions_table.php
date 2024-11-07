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
        Schema::create('sessions', function (Blueprint $table) {
            // Elimina esta línea si ya existe 'id' en la tabla
            // $table->id(); // Eliminar esta línea

            $table->string('id')->unique(); // Cambia este campo para que no sea el auto_increment
            $table->text('payload');
            $table->integer('last_activity');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps(); // Agrega created_at y updated_at si es necesario
        });
    }

    public function down()
    {
        Schema::dropIfExists('sessions');
    }
};
