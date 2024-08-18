<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('followup_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('survey_id')->constrained()->onDelete('cascade');
            $table->foreignId('cohort_id')->constrained('cohorts')->onDelete('cascade');

            $table->string('survey_tag');
            $table->dateTime('date');
            $table->enum('status', ['Completed', 'Pending', 'In Progress']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('followup_surveys');
    }
};
