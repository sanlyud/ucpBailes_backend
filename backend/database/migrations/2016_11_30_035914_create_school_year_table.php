<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schoolYear', function (Blueprint $table) {
            $table->increments('schoolYearID');
            $table->integer('startYear');
            $table->integer('endYear');
            $table->timestamps();
        });

        Schema::create('course', function (Blueprint $table) {
            $table->increments('courseID');
            $table->string('courseName');
            $table->boolean('isActive');
            $table->integer('gradeID')->unsigned();
            $table->integer('categoryID')->unsigned();
            $table->integer('schoolYearID')->unsigned();

            $table->timestamps();
            $table->foreign('schoolYearID')->references('schoolYearID')->on('schoolYear');
            $table->foreign('gradeID')->references('gradeID')->on('grade');
            $table->foreign('categoryID')->references('categoryID')->on('course_category');

        });

        Schema::create('course_teacher', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('teacherID')->unsigned();
            $table->integer('courseID')->unsigned();
            $table->timestamps();

            $table->foreign('teacherID')->references('id')->on('users');
            $table->foreign('courseID')->references('courseID')->on('course');
        });

        Schema::create('course_student', function (Blueprint $table) {
            $table->increments('id');
            $table->string('studentNumber');
            $table->integer('courseID')->unsigned();
            $table->timestamps();

            $table->foreign('studentNumber')->references('studentNumber')->on('student');
            $table->foreign('courseID')->references('courseID')->on('course');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_student');
        Schema::dropIfExists('course_teacher');
        Schema::dropIfExists('course');
        Schema::dropIfExists('schoolYear');
    }
}
