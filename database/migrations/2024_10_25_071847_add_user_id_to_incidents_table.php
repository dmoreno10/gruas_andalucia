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
        // Schema::table('incidents', function (Blueprint $table) {
        //     $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Agregar columna user_id
        // });
    }

    public function down()
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropForeign(['user_id']); // Eliminar la relación
            $table->dropColumn('user_id'); // Eliminar la columna
        });
    }
};
