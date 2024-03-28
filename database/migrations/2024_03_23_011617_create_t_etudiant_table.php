<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

 class  CreateTEtudiantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_etudiant', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->unsignedBigInteger('user_id')->nullable();   // Foreign key
            $table->string('cin', 20)->nullable();
            $table->string('cne', 20)->nullable();
            $table->string('nom_ar', 100)->nullable();
            $table->string('nom_fr', 100)->nullable();
            $table->string('prenom_ar', 100)->nullable();
            $table->string('prenom_fr', 100)->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_de_naissance_ar', 100)->nullable();
            $table->string('lieu_de_naissance_fr', 100)->nullable();
            $table->string('province_naissance_ar', 50)->nullable();
            $table->string('province_naissance_fr', 50)->nullable();
            $table->string('pays_naissance', 50)->nullable();
            $table->string('sexe', 10)->nullable();
            $table->string('nationalité', 30)->nullable();
            $table->string('etat_civile', 50)->nullable();
            $table->string('handicap', 50)->nullable();
            $table->string('nature_handicap', 50)->nullable();
            $table->string('cause_handicap', 200)->nullable();
            $table->string('adresse_etudiant_ar', 500)->nullable();
            $table->string('adresse_etudiant_fr', 500)->nullable();
            $table->string('province_residence', 100)->nullable();
            $table->string('code_postale', 20)->nullable();
            $table->string('commune', 100)->nullable();
            $table->string('pays_residence', 30)->nullable();
            $table->string('hebergement', 30)->nullable();
            $table->string('email1', 100)->nullable();
            $table->string('email_universitaire', 100)->nullable();
            $table->string('mot_de_passe_email_uni', 100)->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('adresse_parents_ar', 500)->nullable();
            $table->string('adresse_parents_fr', 500)->nullable();
            $table->string('code_postale_parents', 20)->nullable();
            $table->string('commune_parents', 100)->nullable();
            $table->string('province_parents', 100)->nullable();
            $table->string('pays_parents', 100)->nullable();
            $table->string('tele_parents1', 30)->nullable();
            $table->string('tele_parents2', 30)->nullable();
            $table->string('situation_parents', 300)->nullable();
            $table->string('profession_pere', 150)->nullable();
            $table->string('profession_mere', 150)->nullable();
            $table->string('cin_pere', 20)->nullable();
            $table->string('cin_mere', 20)->nullable();
            $table->string('etat_pere', 15)->nullable();
            $table->string('etat_mere', 15)->nullable();
            $table->date('date_deces_pere')->nullable();
            $table->date('date_deces_mere')->nullable();
            $table->string('couverture_sante_parent', 50)->nullable();
            $table->string('agence_s', 150)->nullable();
            $table->string('annee_bac', 4)->nullable();
            $table->string('type_bac', 100)->nullable();
            $table->string('pays_bac', 150)->nullable();
            $table->date('date_en_sup')->nullable();
            $table->date('date_en_uni')->nullable();
            $table->date('date_en_etab')->nullable();
            $table->string('statut_etudiant', 50)->nullable();
            $table->string('profession_e', 50)->nullable();
            $table->string('employeur', 50)->nullable();
            $table->string('type_diplome', 100)->nullable();
            $table->string('etablissement', 100)->nullable();
            $table->string('pays_diplome', 50)->nullable();
            $table->string('specialité_diplome', 100)->nullable();
            $table->string('annee_diplome', 4)->nullable();
            $table->string('mention_dip', 15)->nullable();
            $table->string('note_generale', 6)->nullable();
            $table->string('note_s1', 6)->nullable();
            $table->string('note_s2', 6)->nullable();
            $table->string('note_s3', 6)->nullable();
            $table->string('note_s4', 6)->nullable();
            $table->longText('demande_preinscription')->nullable();
            $table->longText('cv_preinscription')->nullable();
            $table->longText('bac_scan')->nullable();
            $table->longText('releve_bac_scan')->nullable();
            $table->longText('diplome_scan')->nullable();
            $table->longText('releves_diplome')->nullable();
            $table->string('confirmation', 3)->nullable();
            $table->string('icc_sim', 20)->nullable();
            $table->string('num_inwi', 14)->nullable();
            $table->integer('engagement_bourse')->nullable();
            $table->integer('type_bourse')->nullable();
            $table->integer('trimestre_bourse')->nullable();
            $table->string('inscription', 3)->nullable();
            $table->date('date_inscription')->nullable();
            $table->date('date_retrait_def')->nullable();
            $table->unsignedBigInteger('id_dip')->nullable();
            $table->unsignedBigInteger('apogee')->nullable();
            
            $table->foreign( 'id_dip' )->references('id') ->on('t_diplome');
            $table->foreign('user_id')->references('id')->on('users')->onDelete(null);

            $table->timestamps();  // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_etudiant');
    }
}