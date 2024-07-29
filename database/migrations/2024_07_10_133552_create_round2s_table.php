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
        Schema::create('round2s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->foreignId('cohort_id')->constrained('cohorts')->onDelete('cascade');

            $table->string('phone')->nullable();
            $table->string('One_Sentence_Description')->nullable();
            $table->string('sector');
            $table->string('other_sector')->nullable();
            $table->string('business_model');
            $table->string('other_business_model')->nullable();
            $table->string('solution');
            $table->string('other_solution')->nullable();
            $table->string('demo_url')->nullable();
            $table->string('traction');
            $table->string('where_customer_find_solution');
            $table->string('revenue_generated');
            $table->string('funding_received');
            $table->string('other_funding_type')->nullable();
            $table->string('sources_of_funding');
            $table->integer('core_team_members');
            $table->boolean('previous_startup_experience');
            $table->string('core_team')->nullable();
            $table->string('core_team_experience')->nullable();
            $table->string('employees_full_time_part_time_interns');
            $table->string('positions_to_fill')->nullable();
            $table->text('goals_next_3_to_12_months');
            $table->text('prex_program_expectations');
            $table->string('accomplish_within_year');
            $table->string('submit_pitch_video_url');
            $table->string('covid19_resilience_impact')->nullable();
            $table->string('social_impact');
            $table->string('covid19_impact');
            $table->string('other_covid19_impact');
            $table->string('critical_support_resource');
            $table->string('best_support_resource');
            $table->string('holding_back_growth_reason')->nullable();
            $table->string('other_comments')->nullable();
            $table->string('race_ethnicity')->nullable();
            $table->string('gender')->nullable();
            $table->string('team_identifiers')->nullable();
            $table->string('if_other_team_identifiers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('round2s');
    }
};
