<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTBaccalaureatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_baccalaureates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_etu')->index()->nullable(); 
            $table->string('CNE')->unique()->index()->nullable(); 
            $table->string('pdf_path')->nullable(); 
            $table->string('status')->default('pending')->nullable(); 
            $table->timestamp('last_request_at')->nullable(); 
            $table->timestamps();
            
           
            $table->foreign('id_etu')->references('id')->on('t_etudiant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baccalaureates');
    }
}
