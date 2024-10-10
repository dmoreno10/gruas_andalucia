<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{ /**
    * Run the migrations.
    */
   public function up(): void
   {
       Schema::create('incidents', function (Blueprint $table) {
           $table->id(); // ID de la incidencia
           $table->string('title'); // Título de la incidencia
           $table->text('description'); // Descripción detallada de la incidencia
           $table->string('status')->default('open'); // Estado de la incidencia (abierta, cerrada, en proceso)
           $table->string('priority')->default('medium'); // Prioridad de la incidencia (baja, media, alta)
           $table->unsignedBigInteger('user_id'); // ID del usuario que reporta la incidencia
           $table->timestamps(); // Campos para created_at y updated_at

           // Clave foránea para relacionar la incidencia con el usuario
           $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
