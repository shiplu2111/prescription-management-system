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
            $table->string('name');

            $table->string('mobile');
            $table->string('email')->nullable();
            $table->UnsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('patient_type');
            $table->string('address');
            $table->string('gender');
            $table->string('age');
            $table->string('date_of_birth')->nullable();
            $table->string('weight')->nullable();
            $table->string('height')->nullable();
            $table->string('image')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('id_type')->nullable();
            $table->string('id_number')->nullable();

            $table->string('guardian_name')->nullable();
            $table->string('guardian_number')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_email')->nullable();

            $table->string('marital_status')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('spouse_number')->nullable();
            $table->string('spouse_email')->nullable();

            $table->string('contact_person')->nullable();
            $table->string('contact_person_number')->nullable();
            $table->string('contact_person_relation')->nullable();
            $table->string('contact_person_email')->nullable();

            $table->boolean('status')->default(true);
            $table->timestamps();
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
