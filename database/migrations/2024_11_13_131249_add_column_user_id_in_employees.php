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
        Schema::table('employees', function (Blueprint $table) {
            // Agregar la columna user_id (relación de uno a muchos)
            $table->unsignedBigInteger('user_id')->nullable()->after('company_id');

            // Definir la clave foránea (relación con la tabla users)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
