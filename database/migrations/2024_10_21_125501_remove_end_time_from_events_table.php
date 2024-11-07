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
    Schema::table('events', function (Blueprint $table) {
        $table->dropColumn('end_time'); // Eliminar el campo end_time
    });
}

public function down()
{
    Schema::table('events', function (Blueprint $table) {
        $table->timestamp('end_time')->nullable(); // Volver a agregar el campo end_time en caso de rollback
    });
}

};
