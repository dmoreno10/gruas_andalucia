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
        Schema::table('configurations', function (Blueprint $table) {
            $table->unsignedBigInteger('user_image_id')->nullable()->after('file_id');
            $table->foreign('user_image_id')->references('id')->on('files')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('configurations', function (Blueprint $table) {
            $table->dropForeign(['user_image_id']);
            $table->dropColumn('user_image_id');
        });
    }

};
