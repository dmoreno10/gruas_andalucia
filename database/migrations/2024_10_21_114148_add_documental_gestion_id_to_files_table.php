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
            $table->unsignedBigInteger('documental_gestion_id')->nullable();

            // Si deseas definir una relación de llave foránea (opcional)
            $table->foreign('documental_gestion_id')->references('id')->on('documental_gestions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropForeign(['documental_gestion_id']);
            $table->dropColumn('documental_gestion_id');
        });
    }

};
