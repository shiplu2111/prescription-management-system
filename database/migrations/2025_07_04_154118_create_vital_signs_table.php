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
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('prescription_id');
            $table->foreign('prescription_id')->references('id')->on('prescriptions')->onDelete('cascade');
            $table->string('pulse_rate')->nullable();
            $table->string('respiration_rate')->nullable();
            $table->string('bp_higher')->nullable();
            $table->string('bp_lower')->nullable();
            $table->string('temperature')->nullable();
            $table->enum('temperature_type', ['F', 'C'])->default('F')->nullable();
            $table->string('weight')->nullable();
            $table->enum('weight_type', ['KG', 'LBS'])->default('KG')->nullable();
            $table->string('height')->nullable();
            $table->enum('height_type', ['Inch', 'CM'])->default('Inch')->nullable();
            $table->string('hart_rate')->nullable();
            $table->string('oxygen_saturation')->nullable();
            $table->string('blood_oxygen')->nullable();
            $table->string('ofs')->nullable();
            $table->string('fhr')->nullable();
            $table->string('bmi')->nullable();
            $table->string('bsa')->nullable();
            $table->string('bmi_status')->nullable();
            $table->string('lpm_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
