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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('apogee')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');//here is the password. 
            $table->string('image')->nullable();//here is the path to the image in storage. 
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('is_uploaded')->default(0);
            $table->string('rapport_file')->nullable();
            $table->string('stage_file')->nullable();
            $table->string('filiere')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
