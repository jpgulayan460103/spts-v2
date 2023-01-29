<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKeys1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('class_record_id')->references('id')->on('class_records')->onDelete('cascade');
        });
        Schema::table('attendance_students', function (Blueprint $table) {
            $table->foreign('attendance_id')->references('id')->on('attendances')->onDelete('cascade');
            $table->foreign('section_student_id')->references('id')->on('section_students')->onDelete('cascade');
        });
        Schema::table('class_records', function (Blueprint $table) {
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
        });
        Schema::table('class_record_quarters', function (Blueprint $table) {
            $table->foreign('class_record_id')->references('id')->on('class_records')->onDelete('cascade');
            $table->foreign('quarter_id')->references('id')->on('libraries')->onDelete('cascade');
        });
        Schema::table('grading_systems', function (Blueprint $table) {
            $table->foreign('subject_category_id')->references('id')->on('libraries')->onDelete('cascade');
        });
        Schema::table('guardians', function (Blueprint $table) {
            $table->foreign('gender_id')->references('id')->on('libraries')->onDelete('cascade');
        });
        Schema::table('libraries', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('libraries')->onDelete('cascade');
        });
        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('adviser_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('school_year_id')->references('id')->on('libraries')->onDelete('cascade');
            $table->foreign('grade_level_id')->references('id')->on('libraries')->onDelete('cascade');
            $table->foreign('track_id')->references('id')->on('libraries')->onDelete('cascade');
        });
        Schema::table('section_students', function (Blueprint $table) {
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
        Schema::table('students', function (Blueprint $table) {
            $table->foreign('gender_id')->references('id')->on('libraries')->onDelete('cascade');
            $table->foreign('guardian_id')->references('id')->on('guardians')->onDelete('cascade');
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->foreign('track_id')->references('id')->on('libraries')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('libraries')->onDelete('cascade');
            $table->foreign('grade_level_id')->references('id')->on('libraries')->onDelete('cascade');
            $table->foreign('subject_category_id')->references('id')->on('libraries')->onDelete('cascade');
        });
        Schema::table('teachers', function (Blueprint $table) {
            $table->foreign('gender_id')->references('id')->on('libraries')->onDelete('cascade');
        });
        Schema::table('units', function (Blueprint $table) {
            $table->foreign('class_record_quarter_id')->references('id')->on('class_record_quarters')->onDelete('cascade');
        });
        Schema::table('unit_actions', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('action_id')->references('id')->on('libraries')->onDelete('cascade');
            $table->foreign('section_student_id')->references('id')->on('section_students')->onDelete('cascade');
        });
        Schema::table('unit_items', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('grading_system_id')->references('id')->on('grading_systems')->onDelete('cascade');
        });
        Schema::table('unit_scores', function (Blueprint $table) {
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
            $table->foreign('unit_item_id')->references('id')->on('unit_items')->onDelete('cascade');
            $table->foreign('section_student_id')->references('id')->on('section_students')->onDelete('cascade');
            $table->foreign('grading_system_id')->references('id')->on('grading_systems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
