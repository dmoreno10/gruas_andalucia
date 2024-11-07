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
        Schema::table('time_entries', function (Blueprint $table) {
            if (!Schema::hasColumn('time_entries', 'user_id')) {
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('time_entries', function (Blueprint $table) {
            // Asegurarse de eliminar la columna solo si existe
            if (Schema::hasColumn('time_entries', 'user_id')) {
                $table->dropForeign(['user_id']); // Eliminar la clave foránea primero
                $table->dropColumn('user_id');
            }
        });

    }
};
