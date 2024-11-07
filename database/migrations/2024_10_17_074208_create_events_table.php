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
        Schema::create('events', function (Blueprint $table) {
            $table->id();  // ID del evento
            $table->string('title');  // Título del evento
            $table->text('description')->nullable();  // Descripción del evento
            $table->timestamp('start_time')->nullable();  // Hora de inicio
            $table->timestamp('end_time')->nullable();  // Hora de fin
            $table->timestamps();  // Created at y updated at
        });
    }

    /**
     * Reverse the migración.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
