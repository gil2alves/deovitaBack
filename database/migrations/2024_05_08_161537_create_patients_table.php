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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('date_birth')->nullable();
            $table->string('cpf', 15);
            $table->string('phone', 15)->nullable();
            $table->enum('sex', ['f', 'm'])->nullable();
            $table->string('address')->nullable();
            $table->string('state', 2)->nullable();
            $table->string('city', 80)->nullable();
            $table->timestamps();

            // Define the foreign key that references the 'users' table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
