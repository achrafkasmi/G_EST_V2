<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('temp_scanned_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_etu')->nullable();
            $table->unsignedBigInteger('id_local')->nullable();
            $table->unsignedBigInteger('id_personnel')->nullable();
            $table->unsignedBigInteger('id_element_pedago')->nullable();
            $table->string('annee_uni')->nullable();
            $table->string('période_seance')->nullable();
            $table->string('unique_code')->nullable();
            $table->timestamps();

            $table->unique(['id_etu', 'id_local', 'id_personnel', 'id_element_pedago', 'annee_uni', 'période_seance'], 'unique_scan');
        });
    }


    /**
     * Reverse the migrations.
     */

    public function down()
    {
        Schema::dropIfExists('temp_scanned_students');
    }
};
