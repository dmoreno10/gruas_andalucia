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
        //     $table->string('logo')->nullable();  // Añadir el campo 'logo'
        // });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('logo');  // Eliminar el campo 'logo' si es necesario
        });
    }

};
