<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCohortIdToApplicantsAndRoundsTables extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('applicants', function (Blueprint $table) {
        //     $table->foreignId('cohort_id')->constrained()->onDelete('cascade');
        // });

        // Schema::table('round1s', function (Blueprint $table) {
        //     $table->foreignId('cohort_id')->constrained()->onDelete('cascade');
        // });
        // Schema::table('round2s', function (Blueprint $table) {
        //     $table->foreignId('cohort_id')->constrained()->onDelete('cascade');
        // });

        // Schema::table('round3s', function (Blueprint $table) {
        //     $table->foreignId('cohort_id')->constrained()->onDelete('cascade');
        // });

        // Schema::table('surveys', function (Blueprint $table) {
        //     $table->foreignId('cohort_id')->constrained()->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('applicants', function (Blueprint $table) {
        //     $table->dropForeign(['cohort_id']);
        //     $table->dropColumn('cohort_id');
        // });

        // Schema::table('round1s', function (Blueprint $table) {
        //     $table->dropForeign(['cohort_id']);
        //     $table->dropColumn('cohort_id');
        // });
        // Schema::table('round2s', function (Blueprint $table) {
        //     $table->dropForeign(['cohort_id']);
        //     $table->dropColumn('cohort_id');
        // });

        // Schema::table('round3s', function (Blueprint $table) {
        //     $table->dropForeign(['cohort_id']);
        //     $table->dropColumn('cohort_id');
        // });
        // Schema::table('surveys', function (Blueprint $table) {
        //     $table->dropForeign(['cohort_id']);
        //     $table->dropColumn('cohort_id');
        // }); Schema::table('followup_urveys', function (Blueprint $table) {
        //     $table->dropForeign(['cohort_id']);
        //     $table->dropColumn('cohort_id');
        // }); Schema::table('onboarding_surveys', function (Blueprint $table) {
        //     $table->dropForeign(['cohort_id']);
        //     $table->dropColumn('cohort_id');
        // });

    }
}
