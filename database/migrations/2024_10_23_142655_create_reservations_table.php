<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('client_name'); // Nombre del cliente
            $table->date('reservation_date'); // Fecha de la reserva
            $table->string('status'); // Estado de la reserva (activo, cancelado, etc.)
            $table->timestamps(); // Crea columnas created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
