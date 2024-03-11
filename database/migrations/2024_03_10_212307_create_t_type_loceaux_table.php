<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTTypeLoceauxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_type_loceaux', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_type_loceaux', 50)->nullable();
            $table->string('nom_type_loceaux', 50)->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_type_loceaux');
    }
};
