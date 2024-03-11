<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTTypePersonnelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_type_personnel', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('nom', 50)->nullable();
            $table->string('prenom', 50)->nullable();
            $table->string('cin', 50)->nullable();
            $table->string('ppr', 50)->nullable();
            $table->string('adresse', 50)->nullable();
            $table->string('tele', 50)->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_type_personnel');
    }
};
