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
        // Schema::table('configurations', function (Blueprint $table) {
        //     // Agregar la columna file_id
        //     $table->foreignId('file_id')->nullable()->constrained('files')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropForeign(['file_id']); // Eliminar la relación
            $table->dropColumn('file_id'); // Eliminar la columna
        });
    }
};
