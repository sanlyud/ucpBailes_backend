<?php

namespace App\Http\Controllers\Api;

use App\MtssDataBasedDecisionToolForm;
use App\MtssListOfInterventionsForm;
use App\MtssMeetingRequestForm;
use App\MtssMeetingNoteForm;
use App\MtssMeetingLogForm;
use App\MtssMeetingLog;
use App\MtssListOfIntervention;
use App\Mtssmemberattended;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Student;
use App\MtssFormMaster;
use App\Course;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class FormController extends Controller
{
    /**
     * Create master from for specified student based on studentNumber in request
     * @param Request $request
     * @return mixed
     */

    public function createMasterForm(Request $request)
    {
        $currentTeacher = JWTAuth::parseToken()->authenticate();
        $student = DB::table('student')
            ->select('studentNumber')
            ->where('studentNumber','=',$request->get('studentNumber'))
            ->get();
        if(!$student) {
            return response()->json(['success' => false, 'error' => 'Student does not exist'], 404);
        } else {
            $masterForm = new MtssFormMaster;
            $masterForm->studentNumber = $request->get('studentNumber');
            if($masterForm->save())
                return response()->json(array('success' => true, 'formMasterID' => $masterForm->formMasterID), 200);
            else
                return respone()->json(['success'=>false, 'error'=>'could_not_create_master_form'], 500);

        }
    }

    /**
     * Get all the master form for specified student
     * @param $studentNumber
     * @return mixed
     */
    public function getMasterForms($studentNumber)
    {
        try {
            $forms = MtssFormMaster::where('studentNumber', '=', $studentNumber)->get();

//            $forms = DB::table('mtssformmaster as m')
//                ->join('student as s','s.studentNumber','=','m.studentNumber')
//                ->select('m.formMasterID','m.created_at as createdDate')->get();
        } catch(\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }

        return response()->json(array('success' => true, 'data' => $forms), 200);



//        $currentTeacher = JWTAuth::parseToken()->authenticate();
//        $student = DB::table('student')
//            ->select('studentNumber')
//            ->where('studentNumber','=',$studentNumber)
//            ->get();
//        if(!$student) {
//            return response()->json(['success' => false, 'message' => 'Student does not exist'], 404);
//        } else {
//            $forms = $student->masterForms()->get()->toArray();
//            return response()->json(['success' => true,'data' => $forms], 200);
//        }
    }

    public function getMasterForm($masterFormID, Request $request)
    {
        try {
            $data = [];
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $studentNumber = $request->get('studentNumber');

            $meetingRequestForm = DB::table('mtssmeetingrequestform')
                ->where('masterFormID','=',$masterFormID)
                ->where('studentNumber','=',$studentNumber)
                ->get();

            array_push($data, $meetingRequestForm);
            $formData["studentNumber"] = $studentNumber;
            $formData["masterFormID"] = $masterFormID;
            $formData["mtssmeetingrequestform"] = $meetingRequestForm;


//            $formData = DB::table('mtssformmaster as m')
//                ->join('mtssmeetingrequestform as mt','m.formMasterID','=','mt.masterFormID')
//                ->where('m.studentNumber','=',$request->get('studentNumber'))
//                ->where('m.formMasterID','=',$masterFormID)
//                ->get();


        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }
        return response()->json(array(
            'success' => true,
            'data' => $formData
        ) , 200);

    }

    public function getMeetingRequestForm($masterFormID) {
        try {
            JWTAuth::parseToken()->authenticate();
            $formData = DB::table('mtssmeetingrequestform')
                ->where('masterFormID','=',$masterFormID)
                ->get();
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }

        return response()->json(
            array(
                'success' => true,
                'data' => $formData
            ) , 200);

    }

    public function createMtssMeetingRequestForm(Request $request)
    {
        $currentTeacher = JWTAuth::parseToken()->authenticate();
        $student = DB::table('student')
            ->select('studentNumber')
            ->where('studentNumber','=',$request->get('studentNumber'))->get();
        if(!$student) {
            return response()->json(['success' => false, 'error' => 'Student does not exist'], 404);
        } else {
            $mtssMeetingRequestForm = new MtssMeetingRequestForm;
            $mtssMeetingRequestForm->masterFormID = $request->get('masterFormID');
            $mtssMeetingRequestForm->studentNumber = $request->get('studentNumber');
            $mtssMeetingRequestForm->teacherFName = $request->get('teacherFName');
            $mtssMeetingRequestForm->teacherLName = $request->get('teacherLName');
            $mtssMeetingRequestForm->dateFrmSubmitted = date_format(date_create($request->get('dateFrmSubmitted')), "Y-m-d");
            $mtssMeetingRequestForm->concernAreaAcademic = $request->get('concernAreaAcademic');
            $mtssMeetingRequestForm->concernAreaBehaviour = $request->get('concernAreaBehaviour');
            $mtssMeetingRequestForm->concernAreaHealthCondtns = $request->get('concernAreaHealthCondtns');
            $mtssMeetingRequestForm->collabAddCurricResourcesIndiv = $request->get('collabAddCurricResourcesIndiv');
            $mtssMeetingRequestForm->collabAddCurricResourcesOutcome = $request->get('collabAddCurricResourcesOutcome');
            $mtssMeetingRequestForm->collabBehavConcernsIndiv = $request->get('collabBehavConcernsIndiv');
            $mtssMeetingRequestForm->collabBehavConcernsOutcome = $request->get('collabBehavConcernsOutcome');
            $mtssMeetingRequestForm->collabESOLConcernsIndiv = $request->get('collabESOLConcernsIndiv');
            $mtssMeetingRequestForm->collabESOLConcernsOutcome = $request->get('collabESOLConcernsOutcome');
            $mtssMeetingRequestForm->collabHealthIssuesIndiv = $request->get('collabHealthIssuesIndiv');
            $mtssMeetingRequestForm->collabHealthIssuesOutcome = $request->get('collabHealthIssuesOutcome');
            $mtssMeetingRequestForm->collabPossibleIntervIndiv = $request->get('collabPossibleIntervIndiv');
            $mtssMeetingRequestForm->collabPossibleIntervOutcome = $request->get('collabPossibleIntervOutcome');
            $mtssMeetingRequestForm->collabReadingMathRecommIndiv = $request->get('collabReadingMathRecommIndiv');
            $mtssMeetingRequestForm->collabReadingMathReccomOutcome = $request->get('collabReadingMathReccomOutcome');
            $mtssMeetingRequestForm->collabSpeechLangIndiv = $request->get('collabSpeechLangIndiv');
            $mtssMeetingRequestForm->collabSpeechLangOutcome = $request->get('collabSpeechLangOutcome');
            $mtssMeetingRequestForm->collabOtherIndiv = $request->get('collabOtherIndiv');
            $mtssMeetingRequestForm->collabOtherOutcome = $request->get('collabOtherOutcome');
            $mtssMeetingRequestForm->dateCumReviewed = date_format(date_create($request->get('dateCumReviewed')),"Y-m-d");
            $mtssMeetingRequestForm->studentPassVisionTest = $request->get('studentPassVisionTest');
            $mtssMeetingRequestForm->studentVisionTestCmnts = $request->get('studentVisionTestCmnts');
            $mtssMeetingRequestForm->studentPassHearnigTest = $request->get('studentPassHearnigTest');
            $mtssMeetingRequestForm->studentHearingTestCmnts = $request->get('studentHearingTestCmnts');
            $mtssMeetingRequestForm->studentMobConcern = $request->get('studentMobConcern');
            $mtssMeetingRequestForm->studentMobConcernCmnts = $request->get('studentMobConcernCmnts');
            $mtssMeetingRequestForm->studentAttendConcern = $request->get('studentAttendConcern');
            $mtssMeetingRequestForm->studentAttendConcernCmnts = $request->get('studentAttendConcernCmnts');
            $mtssMeetingRequestForm->studentIsESOL = $request->get('studentIsESOL');
            $mtssMeetingRequestForm->studentIsESOLCmnts = $request->get('studentIsESOLCmnts');
            $mtssMeetingRequestForm->studentIsESE = $request->get('studentIsESE');
            $mtssMeetingRequestForm->studentIsESECmnts = $request->get('studentIsESECmnts');

            // get the master form for this from
            $masterForm = DB::table('mtssformmaster')
                ->select('formMasterID')
                ->where('formMasterID', '=',$request->get('masterFormID'))->get();
            if(!$masterForm) {
                return response()->json(['success' =>false, 'error' => 'master form does not exist'], 404);
            } else {
                if($mtssMeetingRequestForm->save()) {
                    return response()->json(array('success' => true,
                        'meetingRequestFrmID' => $mtssMeetingRequestForm->meetingRequestFrmID), 200);
                } else {
                    return respone()->json(['success' => false, 'error' => 'could_not_create_meeting_request_form'], 500);
                }
            }

        }
    }

    public function createMtssMeetingNotesForm($masterFormID, Request $request)
    {

        JWTAuth::parseToken()->authenticate();
        $student = DB::table('student')
            ->select('studentNumber')
            ->where('studentNumber','=',$request->get('studentNumber'))->get();
        if(!$student)
            return response()->json(['success' => false, 'error' => 'Student does not exist'], 404);
        $mtssMeetingNotesForm = new MtssMeetingNoteForm;
        $mtssMeetingNotesForm->studentNumber = $request->get('studentNumber');
        $mtssMeetingNotesForm->masterFormID = $masterFormID;
        $mtssMeetingNotesForm->teachersNames = $request->get('teachersNames');
        $mtssMeetingNotesForm->meetingDate = date_format(date_create($request->get('meetingDate')), "Y-m-d");
        $mtssMeetingNotesForm->meetingType = $request->get('meetingType');
        $mtssMeetingNotesForm->graphsNA = $request->get('graphsNA');
        $mtssMeetingNotesForm->NA = $request->get('NA');
        $mtssMeetingNotesForm->graphsAvailable = $request->get('graphsAvailable');
        $mtssMeetingNotesForm->notesFromDiscussion = $request->get('notesFromDiscussion');
        $mtssMeetingNotesForm->nextStep = $request->get('nextStep');
        $mtssMeetingNotesForm->nextMeetingDate = date_format(date_create($request->get('nextMeetingDate')), "Y-m-d");
        $mtssMeetingNotesForm->timeframe = $request->get('timeframe');
        $mtssMeetingNotesForm->nextNotes = $request->get('nextNotes');
        $mtssMeetingNotesForm->participatedParent = $request->get('participatedParent');
        $mtssMeetingNotesForm->dateParentParticipated = date_format(date_create($request->get('dateParentParticipated')), "Y-m-d");
        $mtssMeetingNotesForm->participatedTeacher = $request->get('participatedTeacher');
        $mtssMeetingNotesForm->dateTeacherParticipated = date_format(date_create($request->get('dateTeacherParticipated')), "Y-m-d");
        $mtssMeetingNotesForm->participatedMTSSCoachLiason = $request->get('participatedMTSSCoachLiason');
        $mtssMeetingNotesForm->dateMTSSCoachLiasonParticipated = date_format(date_create($request->get('dateMTSSCoachLiasonParticipated')), "Y-m-d");
        $mtssMeetingNotesForm->participatedSchoolPsychologist = $request->get('participatedSchoolPsychologist');
        $mtssMeetingNotesForm->dateSchoolPsychologistParticipated = date_format(date_create($request->get('dateSchoolPsychologistParticipated')), "Y-m-d");
        $mtssMeetingNotesForm->participatedEseTeacher = $request->get('participatedEseTeacher');
        $mtssMeetingNotesForm->dateEseTeacherParticipated = date_format(date_create($request->get('dateEseTeacherParticipated')), "Y-m-d");
        $mtssMeetingNotesForm->participatedAdmin = $request->get('participatedAdmin');
        $mtssMeetingNotesForm->dateAdminParticipated = date_format(date_create($request->get('dateAdminParticipated')), "Y-m-d");
        $mtssMeetingNotesForm->participatedSocialWorker = $request->get('participatedSocialWorker');
        $mtssMeetingNotesForm->dateSocialWorkerParticipate = date_format(date_create($request->get('dateSocialWorkerParticipate')), "Y-m-d");
        $mtssMeetingNotesForm->participatedOther1 = $request->get('participatedOther1');
        $mtssMeetingNotesForm->dateOther1Participated = date_format(date_create($request->get('dateOther1Participated')), "Y-m-d");
        $mtssMeetingNotesForm->participatedOther2 = $request->get('participatedOther2');
        $mtssMeetingNotesForm->dateOther2Participated = date_format(date_create($request->get('dateOther2Participated')), "Y-m-d");
        $mtssMeetingNotesForm->participatedOther3 = $request->get('participatedOther3');
        $mtssMeetingNotesForm->dateOther3Participated = date_format(date_create($request->get('dateOther3Participated')), "Y-m-d");

//            $masterForm = DB::table('mtssformmaster')
//                ->select('formMasterID')
//                ->where('formMasterID', '=',$request->get('masterFormID'))->get();
//            if(!$masterForm) {
//                return response()->json(['success' =>false, 'message' => 'master form does not exist'], 404);
//            } else {
//                if($mtssMeetingNotesForm->save()) {
//                    return response()->json(array('success' => true,
//                        'meetingRequestFrmID' => $mtssMeetingNotesForm->mtssMeetingNotesFrmID), 200);
//                } else {
//                    return respone()->json(['success' => false, 'message' => 'could_not_create_meeting_request_form'], 500);
//                }
//            }

        try {
            $mtssMeetingNotesForm->save();

        } catch(\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage()], 500);
        }
        return response()->json(array('success' => true,
            'meetingRequestFrmID' => $mtssMeetingNotesForm->mtssMeetingNotesFrmID), 200);


    }

    public function getMtssMeetingNotesForm($masterFormID) {
        try {
            JWTAuth::parseToken()->authenticate();
            $formData = DB::table('mtssmeetingnotesform')
                ->where('masterFormID','=',$masterFormID)
                ->get();

        }
        catch(\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage()], 500);
        }

        return response()->json(
            array(
                'success' => true,
                'data' => $formData
            ) , 200);


    }

    public function createMtssMeetingLogForm($masterFormID, Request $request)
    {
        try {
            JWTAuth::parseToken()->authenticate();
            $meetingLogForm = new MtssMeetingLogForm;
            $meetingLogForm->masterFormID = $masterFormID;
            $meetingLogForm->studentNumber = $request->get('studentNumber');
            if($meetingLogForm->save()) {
                $meetingLogFormID = $meetingLogForm->meetingLogFrmID;
                $logData = $request["data"];
                foreach($logData as $log) {
                    $meetingLog = new MtssMeetingLog;
                    $meetingLog->meetingLogFrmID = $meetingLogFormID;
                    $meetingLog->teacherName = $log["teacherName"];
                    $meetingLog->grade = $log["grade"];
                    $meetingLog->meetingDate = date_format(date_create($log["meetingDate"]), 'Y-m-d');
                    $meetingLog->meetingType = $log["meetingType"];
//                    return response()->json(array("meetingLog" => $meetingLog));
                    if($meetingLog->save()) {
                        $meetingLogID = $meetingLog->mtssMeetingLogID;
                        foreach($log["mtssmembersattended"] as $member) {
                            $memberAttended = new Mtssmemberattended;
                            $memberAttended->mtssMeetingLogID = $meetingLogID;
                            $memberAttended->name = $member["name"];
                            $memberAttended->position = $member["position"];
                            $memberAttended->save();
                        }

                    }
//                    return response()->json(array(
//                        "studentNumber" => $request->get('studentNumber'),
//                        "teacherFName" => $log["teacherFName"]));
                }
            }
//            return response()->json(array("studentNumber" => $request->get('studentNumber')));


        }
        catch(\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage()], 500);
        }
        return response()->json(array('success' => true, 'meetingLogFrmID' => $meetingLogFormID),200);

    }


    public function getMtssMeetingLogForm($masterFormID)
    {
        try {
            $data = [];
            $retData = [];
            $meetingLogsdata = [];

            JWTAuth::parseToken()->authenticate();
            $logsForm = MtssMeetingLogForm::where('masterFormID', '=', $masterFormID)->get();
            //return response()->json(array('success' => true, 'data' => $meetingLogFormID));
            foreach($logsForm as $logForm) {

                $form = [];
                $form["meetingLogFrmID"] = $logForm->meetingLogFrmID;
                $meetingLogs = MtssMeetingLog::where('meetingLogFrmID', $logForm->meetingLogFrmID)->get();
                foreach($meetingLogs as $meetingLog) {
                    $meetingLogData = [];

                    $memberAttended = Mtssmemberattended::where('mtssMeetingLogID',$meetingLog->mtssMeetingLogID)->get();
                    $meetingLogData["mtssMeetingLogID"] = $meetingLog->mtssMeetingLogID;
                    $meetingLogData["meetingLogFrmID"] = $meetingLog->meetingLogFrmID;
                    $meetingLogData["teacherName"] = $meetingLog->teacherName;
                    $meetingLogData["grade"] = $meetingLog->grade;
                    $meetingLogData["meetingDate"] = $meetingLog->meetingDate;
                    $meetingLogData["meetingType"] = $meetingLog->meetingType;
                    $meetingLogData["mtssmembersattended"] = $memberAttended;
                    array_push($meetingLogsdata, $meetingLogData);

                }
                $form["data"] = $meetingLogsdata;
                array_push($data, $form);

            }
            $retData["masterFormID"] = $masterFormID;
            $retData["data"] = $data;



        }
        catch(\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage()], 500);

        }
        return response()->json(array('success' => true, 'data' => $retData), 200);
    }

    public function createmtssListOfInterventionsForm($masterFormID, Request $request) {
        try {
            JWTAuth::parseToken()->authenticate();
            $listOfInterventionsForm = new MtssListOfInterventionsForm;
            $listOfInterventionsForm->masterFormID = $masterFormID;
            $listOfInterventionsForm->teacherName = $request->get('teacherName');
            $listOfInterventionsForm->studentNumber = $request->get('studentNumber');
            $listOfInterventionsForm->grade = $request->get('grade');
            $listOfInterventionsForm->date = date_format(date_create($request->get("date")), 'Y-m-d');
            if($request->get('notes'))
                $listOfInterventionsForm->notes = $request->get('notes');

            if($listOfInterventionsForm->save()) {
                $interventionFormsID = $listOfInterventionsForm->listOfInterventionsFrmID;

                foreach($request["listofinterventions"] as $row) {
                    $listOfIntervention = new MtssListOfIntervention;
                    $listOfIntervention->listOfInterventionsFrmID = $interventionFormsID;
                    if(isset($row["subjectOrIssue"]))
                        $listOfIntervention->subjectOrIssue = $row["subjectOrIssue"];

                    if(isset($row["subjectIssueNotes"]))
                        $listOfIntervention->subjectIssueNotes = $row["subjectIssueNotes"];

//                    $listOfIntervention->date = date_format(date_create($row["date"]), 'Y-m-d');

                    if(isset($row["interventionSupportTier1"]))
                        $listOfIntervention->interventionSupportTier1 = $row["interventionSupportTier1"];

                    if(isset($row["interventionSupportInterv"]))
                        $listOfIntervention->interventionSupportInterv = $row["interventionSupportInterv"];

                    if(isset($row["interventionSupportSupport"]))
                        $listOfIntervention->interventionSupportSupport = $row["interventionSupportSupport"];
                    if(isset($row["interventionSupportChosenItem"]))
                        $listOfIntervention->interventionSupportChosenItem = $row["interventionSupportChosenItem"];

                    if(isset($row["interventionSupportNotes"]))
                        $listOfIntervention->interventionSupportNotes = $row["interventionSupportNotes"];
                    $listOfIntervention->personRespName = $row["personRespName"];
                    $listOfIntervention->personResPosition = $row["personResPosition"];
                    $listOfIntervention->frequencyDays = $row["frequencyDays"];
                    $listOfIntervention->frequencyMinutes = $row["frequencyMinutes"];
                    $listOfIntervention->dateIntervStarted = date_format(date_create($row["dateIntervStarted"]), 'Y-m-d');
                    $listOfIntervention->outcome = $row["outcome"];
                    $listOfIntervention->save();

                }


            }


        }
        catch(\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage()], 500);
        }

        return response()->json(array('success' => true, 'listOfInterventionsFrmID' => $interventionFormsID), 200);

    }

    public function getmtssListOfInterventionsForms($masterFormID) {
        try {
            $data = [];
            $retData = [];
            JWTAuth::parseToken()->authenticate();
            $interventionsForm = DB::table('mtsslistofinterventionsform')->where('masterFormID', $masterFormID)->get();
            //return response()->json(array('success' => true, 'data' => $interventionsForm));
            foreach ($interventionsForm as $interventionForm) {
                $form = [];
                $form["listOfInterventionsFrmID"] = $interventionForm->listOfInterventionsFrmID;
                $form["teacherName"] = $interventionForm->teacherName;
                $form["studentNumber"] = $interventionForm->studentNumber;
                $form["grade"] = $interventionForm->grade;
                $form["date"] = $interventionForm->date;
                $form["notes"] = $interventionForm->notes;
                //$form["listofinterventions"] = MtssListOfInterventionsForm::where('listOfInterventionsFrmID',$interventionForm->listOfInterventionsFrmID)
//                    ->first()
//                    ->listOfInterventions()
//                    ->get()
//                    ->toArray();
                $form["listofinterventions"] = MtssListOfIntervention::where('listOfInterventionsFrmID', $interventionForm->listOfInterventionsFrmID)->get();
//                foreach($intervertions as $intervertion) {
//                    $intervertionData = [];
//
//                    $intervertionData["mtssMeetingLogID"] = $meetingLog->mtssMeetingLogID;
//                    $meetingLogData["meetingLogFrmID"] = $meetingLog->meetingLogFrmID;
//                    $meetingLogData["teacherName"] = $meetingLog->teacherName;
//                    $meetingLogData["grade"] = $meetingLog->grade;
//                    $meetingLogData["meetingDate"] = $meetingLog->meetingDate;
//                    $meetingLogData["meetingType"] = $meetingLog->meetingType;
//                    $meetingLogData["mtssmembersattended"] = $memberAttended;
//                    array_push($meetingLogsdata, $meetingLogData);
//
//                }
                array_push($data, $form);

            }
            $retData["masterFormID"] = $masterFormID;
            $retData["listOfInterventionsForms"] = $data;

        }catch(\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage()], 500);
        }

        return response()->json(array('success' => true, 'data' => $retData), 200);
    }

    public function createMtssDataBasedDecisionToolForm($masterFormID, Request $request) {
        try {
            JWTAuth::parseToken()->authenticate();
            $dataBasedDecisionToolForm = new MtssDataBasedDecisionToolForm;
            $dataBasedDecisionToolForm->masterFormID = $masterFormID;
            $dataBasedDecisionToolForm->meetingDate = date_format(date_create($request->get('meetingDate')), 'Y-m-d');
            $dataBasedDecisionToolForm->AYPsubgroups = $request->get('AYPsubgroups');
            $dataBasedDecisionToolForm->IDnumber = $request->get('IDnumber');
            $dataBasedDecisionToolForm->Retentions = $request->get('Retentions');
            $dataBasedDecisionToolForm->A1 = $request->get('A1');
            $dataBasedDecisionToolForm->A2 = $request->get('A2');
            $dataBasedDecisionToolForm->B1 = $request->get('B1');
            $dataBasedDecisionToolForm->B2 = $request->get('B2');
            $dataBasedDecisionToolForm->B4 = $request->get('B4');
            $dataBasedDecisionToolForm->stateLevelAssesments = $request->get('stateLevelAssesments');
            $dataBasedDecisionToolForm->stateLevelStudentScore = $request->get('stateLevelStudentScore');
            $dataBasedDecisionToolForm->stateLevelAgeGroupScore = $request->get('stateLevelAgeGroupScore');
            $dataBasedDecisionToolForm->districtLevelAssesments = $request->get('districtLevelAssesments');
            $dataBasedDecisionToolForm->districtLevelStudentScore = $request->get('districtLevelStudentScore');
            $dataBasedDecisionToolForm->districtLevelAgeGroupScore = $request->get('districtLevelAgeGroupScore');
            $dataBasedDecisionToolForm->schoolLevelAssesments = $request->get('schoolLevelAssesments');
            $dataBasedDecisionToolForm->schoolLevelStudentScore = $request->get('schoolLevelStudentScore');
            $dataBasedDecisionToolForm->schoolLevelAgeGroupScore = $request->get('schoolLevelAgeGroupScore');
            $dataBasedDecisionToolForm->classLevelAssesments = $request->get('classLevelAssesments');
            $dataBasedDecisionToolForm->classLevelStudentScore = $request->get('classLevelStudentScore');
            $dataBasedDecisionToolForm->classLevelAgeGroupScore = $request->get('classLevelAgeGroupScore');
            $dataBasedDecisionToolForm->subgroupLevelAssesments = $request->get('subgroupLevelAssesments');
            $dataBasedDecisionToolForm->subgroupLevelStudentScore = $request->get('subgroupLevelStudentScore');
            $dataBasedDecisionToolForm->subgroupLevelAgeGroupScore = $request->get('subgroupLevelAgeGroupScore');
            $dataBasedDecisionToolForm->cultureEthnFactors = $request->get('cultureEthnFactors');
            $dataBasedDecisionToolForm->irregAttendanceHighMobilFactors = $request->get('irregAttendanceHighMobilFactors');
            $dataBasedDecisionToolForm->limitedEnglishFactors = $request->get('limitedEnglishFactors');
            $dataBasedDecisionToolForm->chronologicalAgeFactors = $request->get('chronologicalAgeFactors');
            $dataBasedDecisionToolForm->genderFactors = $request->get('genderFactors');

            $dataBasedDecisionToolForm->save();


        } catch(\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage()], 500);
        }

        return response()->json(array(
            'success' => true,
            'dataBasedDecisionToolFrmID' => $dataBasedDecisionToolForm->dataBasedDecisionToolFrmID
        ), 200);

    }

    public function getMtssDataBasedDecisionToolForms($masterFormID) {
        try {
            $data = [];
            JWTAuth::parseToken()->authenticate();
            $data["masterFormID"] = $masterFormID;
            $data["dataBasedDecisionToolForms"] = MtssDataBasedDecisionToolForm::where('masterFormID', $masterFormID)->get();

        }catch(\Exception $ex) {
            return response()->json(['success' => false, 'error' => $ex->getMessage()], 500);
        }

        return response()->json(array('success' => true, 'data' => $data), 200);
    }
}
