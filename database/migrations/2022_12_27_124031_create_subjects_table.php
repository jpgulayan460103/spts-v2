<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_description')->nullable();
            $table->unsignedBigInteger('track_id')->nullable();
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->unsignedBigInteger('grade_level_id')->nullable();
            $table->unsignedBigInteger('subject_category_id')->nullable();
            $table->string('offer_code')->nullable();
            $table->string('subject_code')->nullable();
            $table->timestamps();
            $table->string('uuid')->nullable();
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subjects');
    }
}
