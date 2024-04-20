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
        Schema::create('t_element_modules', function (Blueprint $table) {
            $table->id();
            $table->string('code_element', 50)->nullable();
            $table->unsignedBigInteger('module_parent')->nullable();
            $table->string('type_element', 30)->nullable();
            $table->string('intitule_element', 100)->nullable();
            $table->double('nbr_heures_cours')->nullable();
            $table->double('nbr_heures_td')->nullable();
            $table->double('nbr_heures_tp')->nullable();
            $table->double('nbr_heures_ap')->nullable();
            $table->double('nbr_heures_evaluation')->nullable();
            $table->text('decription_element')->nullable();
            $table->double('coefficient')->nullable();
            $table->timestamps();

            $table->foreign('module_parent')->references('id')->on('t_modules_etape');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_element_modules');
    }
};

