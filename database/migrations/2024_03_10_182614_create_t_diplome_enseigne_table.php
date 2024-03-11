<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDiplomeEnseigneTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_diplome_enseigne', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_diplome_enseigne', 50)->nullable();
            $table->string('nom_diplome_enseigne', 50)->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_diplome_enseigne');
    }
};
