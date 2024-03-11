<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTTypeHandicapTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_type_handicap', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_type_handicap', 50)->nullable();
            $table->string('nom_type_handicap', 50)->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_type_handicap');
    }
};
