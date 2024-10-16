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
        Schema::table('documental_gestion', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(); // Agrega esta línea
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Opcional, si deseas establecer la relación
        });
    }

    public function down()
    {
        Schema::table('documental_gestion', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }

};
