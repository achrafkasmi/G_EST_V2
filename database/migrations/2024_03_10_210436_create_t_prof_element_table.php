<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTProfElementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_prof_element', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('annee_universitaire', 9)->nullable();
            $table->unsignedBigInteger('id_personnel')->nullable();
            //$table->unsignedBigInteger('id_etape')->nullable();

            // Foreign key constraints
            $table->foreign('id_personnel')->references('id')->on('t_personnel')->onDelete('cascade');
            //$table->foreign('id_etape')->references('id')->on('t_etape_diplome')->onDelete('cascade');

            $table->timestamps();  // Created at and Updated at timestamps
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_prof_element');
    }
};
