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
        Schema::create('prescription_revenues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consultation_record_id');
            $table->text('prescription');
            $table->timestamps();


            $table->foreign('consultation_record_id')->references('id')->on('consultation_records')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescription_revenues');
    }
};
