<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTEtapeDiplomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       /* Schema::create('t_etape_diplome', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_etape_diplome', 50)->nullable();
            $table->string('nom_etape_diplome', 50)->nullable();
            $table->unsignedBigInteger('id_diplome')->nullable();
            $table->timestamps();  // Created at and Updated at timestamps

            // Foreign key
            //$table->foreign('id_diplome')->references('id')->on('t_diplome')->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::dropIfExists('t_etape_diplome');*/
    }
}