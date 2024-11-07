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
        Schema::table('incidents', function (Blueprint $table) {
            // Cambiar el tipo de dato si es necesario, pero aquí está correcto como enum
            // Puedes agregar otros valores si es necesario
            $table->enum('status', ['abierto', 'cerrado','en_progreso'])->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            //
        });
    }
};
