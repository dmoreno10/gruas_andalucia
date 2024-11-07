<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessLogsTable extends Migration
{
    /**
     * Ejecuta las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('access_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Relación con la tabla 'users'
            $table->ipAddress('ip_address');
            $table->string('user_agent');
            $table->enum('status', ['success', 'failed', 'logout']); // Estado de acceso
            $table->timestamps(); // Marca de tiempo
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_logs');
    }
}
