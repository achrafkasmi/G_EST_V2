<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTEtablissementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_etablissement', function (Blueprint $table) {
            $table->id();  // Primary key
            $table->string('code_etablissement', 30)->nullable();
            $table->string('nom_etablissement', 100)->nullable();
            $table->timestamps();  // Created at and Updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_etablissement');
    }
};
