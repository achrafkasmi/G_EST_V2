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
        Schema::create('t_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_etu')->nullable();
            $table->string('mac_address')->nullable();
            $table->unsignedBigInteger('id_local')->nullable();
            $table->unsignedBigInteger('id_personnel')->nullable();
            $table->string('Annee', 100)->nullable();
            $table->string('FILIERE', 200)->nullable();
            $table->unsignedBigInteger('id_element_pedago');
            $table->string('type_seance')->nullable();
            $table->string('annee_uni',30)->nullable();
            $table->string('date')->nullable();
            $table->string('période_seance')->nullable();
            $table->boolean('is_absent')->nullable();
            $table->boolean('is_justified')->default(0);
            $table->string('url_justification')->nullable();
            $table->timestamps();
            $table->foreign('id_etu')->references('id')->on('t_etudiant')->onDelete('cascade');
            $table->foreign('id_local')->references('id')->on('t_locaux')->onDelete('cascade');
            $table->foreign('id_personnel')->references('id')->on('t_personnel')->onDelete('cascade');
            $table->foreign('id_element_pedago')->references('id')->on('t_modules_etape')->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_attendance');
    }
};
