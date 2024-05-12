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
        Schema::create('t_personnel_element_pedago', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('personnel_id');
            $table->unsignedBigInteger('id_element_pedago');
            $table->timestamps(); 
             // Define foreign keys 
            $table->foreign('personnel_id')->references('id')->on('t_personnel')->onDelete('cascade'); 
            $table->foreign('id_element_pedago')->references('id')->on('t_modules_etape')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_personnel_element_pedago');
    }
};




