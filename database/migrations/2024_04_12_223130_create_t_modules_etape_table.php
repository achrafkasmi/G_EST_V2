<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTModulesEtapeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_modules_etape', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_etape', 50)->nullable();
            $table->unsignedBigInteger('id_etape')->nullable();
            $table->string('type_etape_element', 30)->nullable();
            $table->string('intitule_element', 100)->nullable();
            $table->double('nbr_heures_cours')->nullable();
            $table->double('nbr_heures_td')->nullable();
            $table->double('nbr_heures_tp')->nullable();
            $table->double('nbr_heures_ap')->nullable();
            $table->double('nbr_heures_evaluation')->nullable();
            $table->text('decription_module')->nullable();
            $table->double('coefficient')->nullable();
            $table->timestamps();  
            //here is the fk that refused to come from t_etape_diplome. 
            $table->foreign('id_etape')->references('id')->on('t_etape_diplome')->onDelete('cascade');

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_modules_etape');
    }
};