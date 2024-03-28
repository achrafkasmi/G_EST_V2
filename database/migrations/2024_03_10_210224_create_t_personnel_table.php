<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTPersonnelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_personnel', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_personnel', 50)->nullable();
            $table->string('nom_personnel', 50)->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
            $table->unsignedBigInteger('user_id')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_personnel');
    }
};
