<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPersonnelForDiplomeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_personnel_for_diplome', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('t_personnel_id');
            $table->unsignedBigInteger('t_diplome_id');
            $table->timestamps();

            $table->foreign('t_personnel_id')->references('id')->on('t_personnel')->onDelete('cascade');
            $table->foreign('t_diplome_id')->references('id')->on('t_diplome')->onDelete('cascade');

            $table->unique(['t_personnel_id', 't_diplome_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('t_personnel_for_diplome');
    }
}
