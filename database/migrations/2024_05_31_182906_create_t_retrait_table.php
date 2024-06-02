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
        Schema::create('t_retrait', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_etu')->nullable();
            $table->string('type_retrait')->nullable();
            $table->text('motif_retrait')->nullable();
            $table->longText('dossier_retrait')->nullable();
            $table->timestamps();



            $table->foreign('id_etu')->references('id')->on('t_etudiant')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_retrait');
    }
};
