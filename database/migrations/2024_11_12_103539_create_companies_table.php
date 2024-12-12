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
        Schema::create('companies', function (Blueprint $table) {
            $table->id(); // Campo para el ID de la empresa
            $table->string('name'); // Nombre de la empresa
            $table->string('address'); // Dirección de la empresa
            $table->string('phone'); // Teléfono de la empresa
            $table->string('email')->unique(); // Email de la empresa
            $table->timestamps(); // Campos de created_at y updated_at
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
