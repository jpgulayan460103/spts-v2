<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_sections', function (Blueprint $table) {
            $table->id();
            $table->string('section_name')->nullable();
            $table->unsignedBigInteger('adviser_id')->nullable();
            $table->unsignedBigInteger('school_year_id')->nullable();
            $table->unsignedBigInteger('grade_level_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('class_sections');
    }
}
