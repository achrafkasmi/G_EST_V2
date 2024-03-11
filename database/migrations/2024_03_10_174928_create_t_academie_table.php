<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTAcademieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_academie', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_academie', 50)->nullable();
            $table->string('nom_academie', 50)->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_academie');
    }
};
