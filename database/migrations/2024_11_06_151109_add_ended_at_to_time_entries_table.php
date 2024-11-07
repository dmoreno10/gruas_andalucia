<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
      /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('time_entries', function (Blueprint $table) {
            $table->timestamp('ended_at')->nullable(); // Agrega la columna ended_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_entries', function (Blueprint $table) {
            $table->dropColumn('ended_at'); // Elimina la columna ended_at
        });
    }
};
