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
        //     $table->string('user_image')->nullable(); // Puedes usar `nullable()` si es opcional
        // });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropColumn('user_image');
        });
    }
};
