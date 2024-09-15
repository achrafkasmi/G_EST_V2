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
        Schema::create('t_documents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_role')->nullable();
            $table->string('intitule_document')->nullable();
            $table->string('type_document')->nullable();
            $table->boolean('is_archived')->nullable();
            $table->longText('document')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_documents');
    }
};
