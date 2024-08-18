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
        Schema::create('round1s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->foreignId('cohort_id')->constrained('cohorts')->onDelete('cascade');

            $table->string('company_website')->nullable();
            $table->string('company_zip_code');
            $table->year('year_company_founded')->nullable();
            $table->integer('number_of_founding_team_members');
            $table->enum('current_product_stage', [
                'Idea',
                'Some Research and/or Business Planning',
                'Prototype Designed',
                'Prototype Developed',
                'Beta Testing',
                'Live Customers',
            ]);
            $table->enum('current_business_stage', [
                'Idea',
                'Startup',
                'Growth',
                'Established',
                'Expansion',
                'Declining',
                'Exit',
            ]);
            $table->enum('company_formed', [
                'No',
                'Yes (LLC)',
                'Yes (B-Corp)',
                'Yes (C-Corp)',
                'Yes (S-Corp)',
                'Yes (Nonprofit)',
                'Other',
            ]);
            $table->string('one_sentence_description', 125);
            $table->enum('company_team_location', [
                'Hawaii Island',
                'Kauai',
                'Lanai',
                'Maui',
                'Molokai',
                'Niihau',
                'Oahu',
                'Other',
            ]);
            $table->string('if_you_selected_other_please_specify')->nullable();
            $table->text('short_problem_description');
            $table->text('detailed_description');
            $table->enum('applied_to_accelerator', [
                'No',
                'Yes - I was accepted and received funding',
                'Yes - I was accepted but there was no funding',
                'Yes - I was accepted but decided to pass',
                'Yes - I was not accepted / did not receive funding',
                'I’m not sure',
            ]);
            $table->string('previous_accelerator_places')->nullable();
            $table->string('If_Yes_please_indicate_ALL_the_PREVIOUS_places')->nullable();
            $table->string('funding_received');
            $table->string('amount_funding_raised');
            $table->string('revenue_generated');
            $table->enum('covid_impact', [
                'No, it has not impacted business.',
                'Yes, and business is still struggling.',
                'Yes, initially but now business is back to near pre-pandemic levels.',
                'Yes, initially but now business is better than ever.',
                'Yes, but business has pivoted.',
            ]);
            $table->text('reason_for_applying');
            $table->text('biggest_challenge');
            $table->string('how_did_you_hear_about_us');
            $table->string('race_ethnicity')->nullable();
            $table->string('gender')->nullable();
            $table->string('additional_demographics')->nullable();
            $table->string('team_identifiers')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('round1s');
    }
};
