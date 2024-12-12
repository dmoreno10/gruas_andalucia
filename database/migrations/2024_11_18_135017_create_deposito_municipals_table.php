<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('municipal_deposit', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('direction');
            $table->string('town');
            $table->integer('status');
            $table->integer('phone');
            $table->integer('mobile_phone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipal-deposit');
    }
};
