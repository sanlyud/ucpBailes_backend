<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtssTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school', function (Blueprint $table) {
            $table->increments('schoolID');
            $table->string('name', 100);

        });

        Schema::create('student', function (Blueprint $table) {
//            $table->increments('studentID');
//            $table->integer('userID')->unsigned();
            $table->integer('schoolID')->unsigned();
            $table->string('studentNumber')->unique();
            $table->integer('grade');
            $table->date('DOB');
            $table->string('studentFName', 50);
            $table->string('studentLName', 50);
            $table->string('studentMName', 50);

//            $table->foreign('userID')->references('id')->on('users');
            $table->primary('studentNumber');
            $table->foreign('schoolID')->references('schoolID')->on('school');
        });

        Schema::create('attendance', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('studentNumber');
            $table->dateTime('dateTaken');
            $table->tinyInteger('student_present');
            $table->tinyInteger('student_absent');
            $table->tinyInteger('student_tardy');

            $table->primary('ID');
            $table->foreign('studentNumber')->references('studentNumber')->on('student');
        });

        Schema::create('teacher_student', function (Blueprint $table){
            $table->integer('teacher_id')->unsigned();
            $table->foreign('teacher_id')->references('id')->on('users');
            $table->string('studentNumber');
            $table->foreign('studentNumber')->references('studentNumber')->on('student');
        });


        Schema::create('mtssFormMaster', function (Blueprint $table) {
            $table->increments('formMasterID');
            $table-> string ('studentNumber');
            $table->timestamps();
//            $table-> integer ('meetingRequestFrmID')->unsigned();
//            $table-> integer ('meetingLogFrmID')->unsigned();
//            $table-> integer ('mtssMeetingNotesFrmID')->unsigned();
//            $table-> integer ('listOfInterventionsFrmID')->unsigned();
//            $table-> integer ('dataBasedDecisionToolFrmID')->unsigned();
//
            $table-> foreign('studentNumber')->references('studentNumber')->on('student');
//            $table-> foreign ('meetingRequestFrmID')-> references ('meetingRequestFrmID')->on('mtssMeetingRequestForm');
//            $table-> foreign ('meetingLogFrmID')-> references ('meetingLogFrmID')->on('mtssMeetingLogForm');
//            $table-> foreign ('mtssMeetingNotesFrmID')-> references ('mtssMeetingNotesFrmID')->on('mtssMeetingNotesForm');
//            $table-> foreign ('listOfInterventionsFrmID')-> references ('listOfInterventionsFrmID')->on('mtssListOfInterventionsForm');
//            $table-> foreign ('dataBasedDecisionToolFrmID')-> references ('dataBasedDecisionToolFrmID')->on('mtssDataBasedDecisionToolForm');
        });

        Schema::create('mtssMeetingRequestForm', function (Blueprint $table) {
            $table-> increments ('meetingRequestFrmID');
            $table->integer('masterFormID')->unsigned();
            $table-> string ('studentNumber');
            $table-> string ('teacherFName');
            $table-> string ('teacherLName');

            $table-> date ('dateFrmSubmitted');

            $table-> string('concernAreaAcademic');
            $table-> string('concernAreaBehaviour');
            $table-> string('concernAreaHealthCondtns');

            $table-> string('collabAddCurricResourcesIndiv');
            $table-> text('collabAddCurricResourcesOutcome');
            $table-> text('collabBehavConcernsIndiv');
            $table-> text('collabBehavConcernsOutcome');
            $table-> string('collabESOLConcernsIndiv');
            $table-> text('collabESOLConcernsOutcome');
            $table-> string('collabHealthIssuesIndiv');
            $table-> text('collabHealthIssuesOutcome');
            $table-> string('collabPossibleIntervIndiv');
            $table-> text('collabPossibleIntervOutcome');
            $table-> string('collabReadingMathRecommIndiv');
            $table-> text('collabReadingMathReccomOutcome');
            $table-> string('collabSpeechLangIndiv');
            $table-> text('collabSpeechLangOutcome');
            $table-> string('collabOtherIndiv');
            $table-> text('collabOtherOutcome');
            $table-> date ('dateCumReviewed');
            $table-> boolean ('studentPassVisionTest');
            $table-> text ('studentVisionTestCmnts');
            $table-> boolean ('studentPassHearnigTest');
            $table-> text ('studentHearingTestCmnts');
            $table-> boolean ('studentMobConcern');
            $table-> text ('studentMobConcernCmnts');
            $table-> boolean ('studentAttendConcern');
            $table-> text ('studentAttendConcernCmnts');
            $table-> boolean('studentIsESOL');
            $table-> text ('studentIsESOLCmnts');
            $table-> boolean ('studentIsESE');
            $table-> text ('studentIsESECmnts');

            $table->foreign('studentNumber')->references('studentNumber')->on('student');
            $table->foreign('masterFormID')->references('formMasterID')->on('mtssFormMaster');
        });

        Schema::create('mtssMeetingLogForm', function (Blueprint $table) {
            $table->increments('meetingLogFrmID');
            $table->integer('masterFormID')->unsigned();

            $table-> string ('studentNumber');

            $table->foreign('studentNumber')->references('studentNumber')->on('student');
            $table->foreign('masterFormID')->references('formMasterID')->on('mtssFormMaster');
        });

        Schema::create('mtssMeetingLog', function (Blueprint $table) {
            $table->increments ('mtssMeetingLogID');

            $table-> integer ('meetingLogFrmID')->unsigned();
            $table-> string ('teacherFName');
            $table-> string ('teacherLName');
            $table-> integer ('grade');
            $table-> date ('meetingDate');
            $table-> string ('meetingType');

            $table->foreign('meetingLogFrmID')->references('meetingLogFrmID')->on('mtssMeetingLogForm');
        });
        Schema::create('mtssMembersAttended', function (Blueprint $table) {
            $table-> increments ('membAttendedID');
            $table-> integer ('mtssMeetingLogID')->unsigned();
            $table-> string ('name');
            $table-> string ('position');

            $table->foreign('mtssMeetingLogID')->references('mtssMeetingLogID')->on('mtssMeetingLog');
        });
//        Schema::create('mtssMeetingLogForm', function (Blueprint $table) {
//            $table->increments('meetingLogFrmID');
//            $table->string ('studentNumber')->unique();
//            $table->foreign('studentNumber')->references('studentNumber')->on('student');
//        });

        Schema::create('mtssMeetingNotesForm', function (Blueprint $table) {
            $table->increments('mtssMeetingNotesFrmID');
            $table-> string ('studentNumber')->unique();
            $table->integer('masterFormID')->unsigned();
            $table-> text ('teachersNames');
            $table-> date ('meetingDate');
            $table-> string('meetingType');
            $table-> boolean ('graphsNA');
            $table-> boolean ('NA');
            $table-> boolean ('graphsAvailable');
            $table-> text ('notesFromDiscussion');
            $table-> text ('nextStep');
            $table-> date ('nextMeetingDate');
            $table-> string ('timeframe');
            $table-> string ('nextNotes');
            $table-> string ('participatedParent');
            $table-> date ('dateParentParticipated');
            $table-> string ('participatedTeacher');
            $table-> date ('dateTeacherParticipated');
            $table-> string('participatedMTSSCoachLiason');
            $table-> date ('dateMTSSCoachLiasonParticipated');
            $table-> string('participatedSchoolPsychologist');
            $table-> date ('dateSchoolPsychologistParticipated');
            $table-> string('participatedEseTeacher');
            $table-> date  ('dateEseTeacherParticipated');
            $table-> string('participatedAdmin');
            $table-> date  ('dateAdminParticipated');
            $table-> string('participatedSocialWorker');
            $table-> date  ('dateSocialWorkerParticipate');
            $table-> string('participatedOther1');
            $table-> date  ('dateOther1Participated');
            $table-> string ('participatedOther2');
            $table-> date  ('dateOther2Participated');
            $table-> string ('participatedOther3');
            $table-> date  ('dateOther3Participated');

            $table->foreign('studentNumber')->references('studentNumber')->on('student');
            $table->foreign('masterFormID')->references(' ')->on('mtssFormMaster');
        });


        Schema::create('mtssListOfInterventionsForm', function (Blueprint $table)
        {
            $table->increments('listOfInterventionsFrmID');
            $table->integer('masterFormID')->unsigned();
            $table-> string ('teacherName');
            $table-> string ('studentNumber');
            $table-> integer ('grade');
            $table-> date ('date');
            $table-> text ('notes');

            $table->foreign('studentNumber')->references('  ')->on('student');
            $table->foreign('masterFormID')->references('formMasterID')->on('mtssFormMaster');
        });
        Schema::create('mtssListOfInterventions', function (Blueprint $table)
        {
            $table->increments('listOfInterventionsID');
            $table-> integer ('listOfInterventionsFrmID')->unsigned();

            //subject or issue: reading, math, writing, behavior
            $table->  string ('subjectOrIssue', 100);
            $table-> text ('subjectIssueNotes');
            $table-> date ('date');
            $table-> boolean ('interventionSupportTier1');
            $table-> boolean ('interventionSupportInterv');
            $table-> boolean ('interventionSupportSupport');
            $table-> string ('interventionSupportChosenItem');
            $table-> text ('interventionSupportNotes');
            $table-> string ('personRespName');
            $table-> string ('personResPosition');
            $table-> string ('frequencyDays');
            $table-> string ('frequencyMinutes');
            $table-> date ('dateIntervStarted');
            $table-> text ('outcome');

            $table->foreign('listOfInterventionsFrmID')->references('listOfInterventionsFrmID')->on('mtssListOfInterventionsForm');
        });

        Schema::create('mtssDataBasedDecisionToolForm', function (Blueprint $table)
        {
            $table->increments('dataBasedDecisionToolFrmID');
            $table->integer('masterFormID')->unsigned();
            $table-> date ('meetingDate');
            $table-> string ('AYPsubgroups', 100);
            $table-> string ('IDnumber');
            $table-> string ('Retentions');

            $table-> boolean ('A1');
            $table-> boolean ('A2');
            $table-> boolean ('B1');
            $table-> boolean ('B2');
            $table-> boolean ('B4');
            $table-> text   ('stateLevelAssesments');
            $table-> string ('stateLevelStudentScore');
            //not sure whether it is number or letter
            $table-> string ('stateLevelAgeGroupScore');
            $table-> text   ('districtLevelAssesments');
            $table-> string ('districtLevelStudentScore');
            $table-> string ('districtLevelAgeGroupScore');
            $table-> text   ('schoolLevelAssesments');
            $table-> string ('schoolLevelStudentScore');
            $table-> string ('schoolLevelAgeGroupScore');
            $table-> text   ('classLevelAssesments');
            $table-> string ('classLevelStudentScore');
            $table-> string ('classLevelAgeGroupScore');
            $table-> text   ('subgroupLevelAssesments');
            $table-> string ('subgroupLevelStudentScore');
            $table-> string ('subgroupLevelAgeGroupScore');

            $table-> boolean ('cultureEthnFactors');
            $table-> boolean ('irregAttendanceHighMobilFactors');
            $table-> boolean ('limitedEnglishFactors');
            $table-> boolean ('chronologicalAgeFactors');
            $table-> boolean ('genderFactors');
            $table->foreign('masterFormID')->references('formMasterID')->on('mtssFormMaster');
        });





    }


    /**
     * Reverse the migrations.
     *
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school');
        Schema::dropIfExists('student');
        Schema::dropIfExists('teacher_student');
        Schema::dropIfExists('mtssFormMaster');
        Schema::dropIfExists('mtssMeetingRequestForm');
        Schema::dropIfExists('mtssMembersAttended');
        Schema::dropIfExists('mtssMeetingLog');
        Schema::dropIfExists('mtssMeetingLogForm');
        Schema::dropIfExists('mtssMeetingNotesForm');
        Schema::dropIfExists('mtssListOfInterventionsForm');
        Schema::dropIfExists('mtssListOfInterventions');
        Schema::dropIfExists('mtssDataBasedDecisionToolForm');


    }
}
