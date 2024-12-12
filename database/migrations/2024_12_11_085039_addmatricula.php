<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->unsignedBigInteger('municipal_deposit_id'); 
            $table->foreign('municipal_deposit_id')
                  ->references('id')
                  ->on('municipal_deposit')
                  ->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropForeign(['municipal_deposit_id']);
            
            $table->dropColumn('municipal_deposit_id');
        });    
       
    }
    
    
};
