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
     Schema::create('prescriptions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('patient_id');
        $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        $table->unsignedBigInteger('doctor_id');
        $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
        $table->unsignedBigInteger('chamber_id')->nullable();
        $table->foreign('chamber_id')->references('id')->on('chambers')->onDelete('cascade');
        $table->longText('complaint')->nullable();
        $table->longText('investigation')->nullable();
        $table->longText('prescription_medicines')->nullable();
        $table->string('patient_name')->nullable();
        $table->string('patient_age')->nullable();
        $table->string('patient_gender')->nullable();
        $table->string('patient_mobile')->nullable();
        $table->string('patient_address')->nullable();
        $table->string('date');
        $table->string('next_visit_date')->nullable();
        $table->string('next_visit_fee')->nullable();
        $table->longText('advice')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};
