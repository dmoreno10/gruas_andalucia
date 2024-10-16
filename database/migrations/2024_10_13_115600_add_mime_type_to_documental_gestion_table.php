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
        if (!Schema::hasColumn('documental_gestion', 'mime_type')) {
            $table->string('mime_type')->nullable();
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documental_gestion', function (Blueprint $table) {
            //
        });
    }
};
