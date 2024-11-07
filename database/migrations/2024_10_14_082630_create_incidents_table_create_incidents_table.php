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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('title');
            $table->string('description'); // Descripción del incidente
            $table->enum('status', ['abierto', 'closed']); // Estado del incidente
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Relación con la tabla de usuarios
            $table->timestamps(); // Marcas de tiempo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
