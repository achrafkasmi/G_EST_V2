<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_diplome', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_personnel');
            $table->string('code_diplome');
            $table->string('intitule_diplome_fr');
            $table->string('intitule_diplome_ar')->nullable();
            $table->date('date_accreditation');
            $table->integer('anne_debut_accreditation');
            $table->integer('anne_fin_accreditation');
            $table->enum('etape_diplome', ['S1', 'S2', 'S3', 'S4', 'S5', 'S6']);
            $table->timestamps();

            $table->foreign('id_personnel')->references( 'id' )->on( 't_personnel' );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_diplome');
    }
};
