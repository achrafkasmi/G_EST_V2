<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTDiplomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_diplomes', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_diplome', 50)->nullable();
            $table->string('nom_diplome', 50)->nullable();
            $table->integer('duree_accreditation_diplome')->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_diplomes');
    }
};
