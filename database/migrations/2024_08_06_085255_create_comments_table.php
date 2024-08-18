<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->foreignId('cohort_id')->constrained('cohorts')->onDelete('cascade');

            $table->foreignId('round1_id')->nullable()->constrained('round1s')->onDelete('cascade');
            $table->foreignId('round2_id')->nullable()->constrained('round2s')->onDelete('cascade');
            $table->foreignId('round3_id')->nullable()->constrained('round3s')->onDelete('cascade');
            $table->text('feedback')->nullable();
            $table->enum('decision', ['accepted', 'rejected'])->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
