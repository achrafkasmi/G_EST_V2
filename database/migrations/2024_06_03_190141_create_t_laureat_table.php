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
        Schema::create('t_laureat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diplome')->nullable();
            $table->unsignedBigInteger('id_etu')->nullable();
            $table->longText('path_dossier_lautreat')->nullable();
            $table->string('annee_uni')->nullable();
            $table->timestamps();


            $table->foreign('diplome')->references('id')->on('t_diplome')->onDelete('cascade');
            $table->foreign('id_etu')->references('id')->on('t_etudiant')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_laureat');
    }
};
