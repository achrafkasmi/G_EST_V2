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
        Schema::create('t_etudiant_etape', function (Blueprint $table) {
            $table->id(); 
            $table->string('annee_universitaire', 9)->nullable();
            $table->unsignedBigInteger('id_etape')->nullable();
            $table->unsignedBigInteger('id_etu')->nullable();
            $table->timestamps();  
        

            $table->foreign('id_etape')->references('id')->on('t_etape_diplome')->onDelete('cascade');
            $table->foreign('id_etu')->references('id')->on('t_etudiant')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_etudiant_etape');
    }
};
