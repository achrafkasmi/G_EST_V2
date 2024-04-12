<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDossierStageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_dossier_stage', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->unsignedBigInteger('id_etu')->nullable();
            $table->string('type_dossier', 50)->nullable();
            $table->longText('dossier_stage')->nullable();
            $table->string('annee_universitaire', 9)->nullable();
            $table->longText('rapport')->nullable();
            $table->string('validation_prof', 10)->nullable();
            $table->text('observation_prof')->nullable();
            $table->boolean('validation_admin')->default(false)->nullable();
            $table->text('observation_admin')->nullable();
            $table->boolean('is_recommanded')->default(false)->nullable();
            $table->text('titre_rapport')->nullable();
            $table->string('image_page_garde')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('id_etu')->references('id')->on('t_etudiant')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_dossier_stage');
    }
};
