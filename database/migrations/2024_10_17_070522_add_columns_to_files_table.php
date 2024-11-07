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
        Schema::table('files', function (Blueprint $table) {
            $table->string('file_path');     // Para almacenar la ruta del archivo
            $table->string('mime_type');     // Para almacenar el tipo MIME del archivo
            $table->bigInteger('file_size'); // Para almacenar el tamaño del archivo en bytes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn(['file_path', 'mime_type', 'file_size']);
        });
    }
};
