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
            // Agregar la columna company_id (relación de uno a muchos)
            $table->unsignedBigInteger('company_id')->nullable()->after('id');

            // Definir la clave foránea (relación con la tabla companies)
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna
            $table->dropForeign(['company_id']);
            $table->dropColumn('company_id');
        });
    }
};
