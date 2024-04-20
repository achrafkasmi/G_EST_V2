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
            $table->unsignedBigInteger('id_personnel');
            $table->unsignedBigInteger('id_modules_etape');

            // Foreign key constraints
            $table->foreign('id_personnel')->references('id')->on('t_personnel')->onDelete('cascade');
            $table->foreign('id_modules_etape')->references('id')->on('t_modules_etape')->onDelete('cascade');

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
