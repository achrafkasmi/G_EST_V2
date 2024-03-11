<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_region', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_region', 50)->nullable();
            $table->string('nom_region', 50)->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_region');
    }
};
