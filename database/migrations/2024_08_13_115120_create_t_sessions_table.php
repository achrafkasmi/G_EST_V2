<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('t_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_local')->constrained('t_locaux')->nullable();
            $table->foreignId('id_personnel')->constrained('t_personnel')->nullable();
            $table->foreignId('id_element_pedago')->constrained('t_modules_etape')->nullable();
            $table->string('annee')->nullable();
            $table->string('filiere')->nullable();
            $table->string('annee_uni')->nullable();
            $table->string('periode_seance')->nullable();
            $table->string('type_seance')->nullable();
            $table->timestamp('session_date')->nullable();
            $table->timestamps();
        });
    }
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sessions');
    }
};
