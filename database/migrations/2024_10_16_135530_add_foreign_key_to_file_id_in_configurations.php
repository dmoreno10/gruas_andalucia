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
        //     // Asegúrate de que la columna 'file_id' sea una clave foránea
        //     $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
        // });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropForeign(['file_id']);
        });
    }
};
