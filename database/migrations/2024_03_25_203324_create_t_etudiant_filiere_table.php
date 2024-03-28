<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTEtudiantFiliereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_etudiant_filiere', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('annee_universitaire', 9)->nullable();
            $table->unsignedBigInteger('id_dip')->nullable();
            $table->unsignedBigInteger('id_etu')->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
        

            // Foreign keys
            $table->foreign('id_dip')->references('id')->on('t_diplome')->onDelete('cascade');
            $table->foreign('id_etu')->references('id')->on('t_etudiant')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_etudiant_filiere');
    }
};
