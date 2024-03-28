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
        Schema::create('t_notification', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_etu')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();   // Foreign key
            $table->longText('text_message')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete(null);
            $table->foreign('id_etu')->references('id')->on('t_etudiant')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_notification');
    }
};
