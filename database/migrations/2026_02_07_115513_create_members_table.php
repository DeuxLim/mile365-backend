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
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();

            $table->date('birthdate')->nullable();
            $table->string('gender')->nullable();

            $table->string('country')->nullable();
            $table->string('province')->nullable();
            $table->string('city')->nullable();
            $table->string('barangay')->nullable();

            $table->json('training_types')->nullable();
            $table->string('experience_level')->nullable();
            $table->integer('years_running')->nullable();
            $table->integer('weekly_distance_km')->nullable();
            $table->string('average_run_pace')->nullable();
            $table->string('preferred_run_time')->nullable();
            $table->text('goals')->nullable();

            $table->date('joined_at'); // date approved

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
