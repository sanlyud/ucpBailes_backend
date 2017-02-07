<?php
/**
 * Created by IntelliJ IDEA.
 * User: Khanh Bui
 * Date: 11/15/2016
 * Time: 10:24 PM
 */

namespace App\Http\Controllers\Api;

use App\MtssMeetingRequestForm;
use App\MtssMeetingNoteForm;
use App\MtssMeetingLogForm;
use App\MtssMeetingLog;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Student;
use App\MtssFormMaster;
use App\Course;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class TeacherController extends Controller {

    /**
     * Display all the student for the teacher
     * @return Response
     */
    public function index() {
        $currentTeacher = JWTAuth::parseToken()->authenticate();
        return $currentTeacher
            ->students()
            ->orderBy('studentNumber')
            ->get()
            ->toArray();
    }

    /**
     * Display the specified student
     * @param $studentNumber
     * @return mixed
     */

    public function showStudent($studentNumber)
    {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $student = DB::table('student')
                ->select('*')
                ->where('studentNumber','=',$studentNumber)->get();

        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex), 500);
        }
        return response()->json(array('success' => true, 'data' => $student), 200);

    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function createStudent(Request $request)
    {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $student = new Student;
            $student->schoolID = $request->get('schoolID');
            $student->studentNumber = $request->get('studentNumber');
            $student->gradeID = $request->get('gradeID');
            $student->studentDOB = date_format(date_create($request->get('studentDOB')), "Y-m-d");
            $student->studentFName = $request->get('studentFName');
            $student->studentLName = $request->get('studentLName');
            $student->studentMName = $request->get('studentMName');
            if($student->save())
                return response()->json(array('success' => true, 'studentNumber' => $student->studentNumber), 200);

        } catch(\Exception $ex)  {
            return response()->json(array('success' => false, 'error' => $ex), 500);
        }


    }

    /**
     * Edit the information of a specific student
     * @param $studentNumber
     * @param Request $request
     * @return mixed
     */

    public function editStudent($studentNumber, Request $request)
    {
        try {
//            $currentTeacher = JWTAuth::parseToken()->authenticate();
//            $student = DB::table('student')
//                ->select('studentNumber')
//                ->where('studentNumber', '=', $studentNumber)
//                ->get();
            $student = Student::where('studentNumber', $studentNumber)->first();
            if(!$student) {
                return response()->json(array('success' => false, 'message' => 'studentNumber does not exist.'), 404);
            } else {
                $input = $request->all();
                Student::where('studentNumber', $studentNumber)
                    ->update($input);
//                $student->fill($input)->save();
            }
        }catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }
        return response()->json(array('success' => true, 'message' => 'student data was updated.'), 200);
    }

    /**
     * Create a course
     * @param Request $request
     * @return mixed
     */
    public function createCourse(Request $request)
    {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $course = new Course;
            $course->courseName = $request->get('courseName');
            $course->isActive = $request->get('isActive');
            $course->gradeID = $request->get('gradeID');
            $course->categoryID = $request->get('categoryID');
            $course->schoolYearID = $request->get('schoolYearID');
            if($course->save())
                return response()->json(array('success' => true, 'studentNumber' => $course->studentNumber), 200);

        } catch (Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }

    }

    public function editCourse($courseID, Request $request)
    {
        $currentTeacher = JWTAuth::parseToken()->authenticate();
        $course = DB::table('course')
                    ->select('courseID')
                    ->where('courseID', '=', $courseID)->get();
        if(!$course) {
            return response()->json(array('success' => false, 'error' => 'course does not exist.'), 404);
        } else {
            $input = $request->all();
            try {
                $course->fill($input)->save();
            } catch (\Illuminate\Database\QueryException $ex) {
                return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

            }
                return response()->json(array('success' => true, 'message' => 'course data was updated.'), 200);



        }
    }

    public function showCourse($courseID)
    {
        $currentTeacher = JWTAuth::parseToken()->authenticate();
        $course = DB::table('course')
            ->select('*')
            ->where('courseID','=', $courseID)->get();
        if(!$course) {
            return response()->json(array('success' => false, 'error' => 'course does not exist.'), 404);
        }
        return response()->json(array('success' => true, 'data' => $course), 200);

    }

    public function searchCourse(Request $request)
    {

        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $course = DB::table('users')
                ->join('course_teacher', 'users.id','=','course_teacher.teacherID')
                ->join('course','course_teacher.courseID','=','course.courseID')
                ->select('course.*')
                ->where('course.courseName','=',$request->get('courseName'))
                ->where('course.gradeLevel', '=', $request->get('gradeLevel'))
                ->where('course.schoolYearID','=', $request->get('schoolYearID'))
                ->where('users.lastName', '=', $request->get('teacherLName'))
                ->get();
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }
            return response()->json(array('success' => true, 'data' => $course), 200);



    }

    public function getAllCourses() {

        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $courses = DB::table('course')
                ->select('*')
                ->orderBy('courseName')
                ->get();

        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }
            return response()->json(array('success' => true, 'data' => $courses), 200);



    }

    public function getAllUnassignedCourses() {

        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $courses = DB::table('course as c')
                ->leftjoin('course_teacher as ct', 'c.courseID', '=', 'ct.courseID')
                ->select('c.courseID', 'c.courseName')
                ->where('ct.teacherID','=',null)
                ->orderBy('courseName')
                ->get();

        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }
        return response()->json(array('success' => true, 'data' => $courses), 200);



    }

    public function getSchoolYears() {

        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $schoolYears = DB::table('schoolyear')->get();
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }

        $data = array();
        foreach($schoolYears as $schoolYear)
        {
            $data[] = array('schoolYearID' => $schoolYear->schoolYearID,
                'schoolYearName'=>$schoolYear->startYear."-".$schoolYear->endYear);
        }
        return response()->json(array('success' => true, 'data' => $data), 200);

    }

    public function getStudentsAtGrade($grade)
    {

        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $students = DB::table('student')
                ->select('studentNumber', 'studentFName', 'studentLName', 'grade')
                ->where('grade', '=', $grade)
                ->get();
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }
        return response()->json(array('success' => true, 'data' => $students), 200);

    }

    public function getCoursesAtGrade($grade)
    {

        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $courses = DB::table('course')

                ->select('course.courseID', 'course.courseName','course.gradeID')
                ->where('course.gradeID', '=', $grade)
                ->get();
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }
        return response()->json(array('success' => true, 'data' => $courses), 200);
    }

    public function assignCoursesToStudents(Request $request) {

        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            foreach ($request->json() as $student) {

//                return response()->json(array('success' => true, 'data'=>$student), 200);
                $studentNumber = $student["studentNumber"];
                $courseIDs= $student["courseIDs"];
                //return response()->json(array('success' => true, 'data'=>$courseIDs), 200);
                foreach($courseIDs as $courseID) {
//                    return response()->json(array('success' => true, 'data'=>$courseID), 200);
                    DB::table('course_student')->insert(
                        [
                            'studentNumber' => $studentNumber,
                            'courseID' => $courseID
                        ]
                    );
                }

            }

        } catch (\Exception $ex){
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }

        return response()->json(array('success' => true, 'message' => 'courses assigned successfully'), 200);



    }

    public function getCategories()
    {

        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $categories = DB::table('course_category')->get()->toArray();
        }catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }
        return response()->json(array('success' => true, 'data' => $categories), 200);
    }

    public function getGrades()
    {
        $currentTeacher = JWTAuth::parseToken()->authenticate();
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $grades = DB::table('grade')->get()->toArray();
        }catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);

        }
        return response()->json(array('success' => true, 'data' => $grades), 200);
    }

    public function getCoursesByGradeAndCat(Request $request)
    {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $gradeID = $request->get('gradeID');
            $categoryID = $request->get('categoryID');
            $courses = DB::table('course')
                        ->join('course_teacher','course_teacher.courseID','=','course.courseID')
                        ->join('course_category','course_category.categoryID','=','course.categoryID')
                        ->select('course.courseID', 'course.courseName','course.gradeID', 'course_category.categoryID')
                        ->where('course_teacher.teacherID','=',$currentTeacher->id)
                        ->where('course.gradeID','=',$gradeID)
                        ->where('course_category.categoryID','=',$categoryID)
                        ->get();



        } catch(\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }
        return response()->json(array('success' => true, 'data' => $courses), 200);

    }

    public function getStudentsGrades($courseID) {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $data = [];
            $studentData = [];
            $assignmentData = [];
            $assignmentTypeData = [];

            $start = 0;
            $i = 0;
            $j = 0;
            $prevStudID = 0;
            $prevStudName = '';
            $prevTypeID = 0;
            $prevTypeName = '';
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $students = DB::table('assignment as a')
                ->join('assignmenttype as at','a.typeID','=','at.typeID')
                ->join('assignmentscore as ass','a.assignmentID','=','ass.assignmentID')
                ->join('student as s', 's.studentNumber','=','ass.studentNumber')
                ->select('a.assignmentID','a.assignmentName','ass.score','at.typeID','at.name','s.studentNumber','s.studentFName','s.studentLName')
                ->where('a.courseID','=', $courseID)
                ->orderBy('s.studentNumber','a.type', 'a.name')
                ->get();
            foreach($students as $student) {
                // flag for starting
                if($start == 0) {
                    $start = 1;
                    $prevStudID = $student->studentNumber;
                    $prevStudName = $student->studentFName." ".$student->studentLName;
                    $prevTypeID = $student->typeID;
                    $prevTypeName = $student->name;

                }
                // push student data into the data[]
                if ($prevStudID != $student->studentNumber) {

                    $studentData["studentNumber"] = $prevStudID;
                    $studentData["studentName"] = $prevStudName;
                    $studentData["data"] = $assignmentTypeData;
                    array_push($data, $studentData);
                    $studentData = [];
                    $assignmentData = [];
                    $assignmentTypeData = [];
                }
                //flag for assignment type

//                if($prevTypeID != $student->typeID) {
//                    $assignmentData = array(
//                        "typeID" => $prevTypeID,
//                        "type" => $prevTypeName,
//                        "data" => $assignmentTypeData
//                    );
//                    array_push($studentData, $assignmentData);
//                    $assignmentData = [];
//                    $assignmentTypeData = [];
//                }
                array_push($assignmentTypeData,

                        array(
                            "assignmentID" => $student->assignmentID,
                            "assignmentType" => $student->name,
                            "assignmentName" => $student->assignmentName,
                            "score" => $student->score
                        )


                );

                $prevStudID = $student->studentNumber;
                $prevStudName = $student->studentFName." ".$student->studentLName;
                $prevTypeID = $student->typeID;
                $prevTypeName = $student->name;

            }


            $studentData["studentNumber"] = $prevStudID;
            $studentData["studentName"] = $prevStudName;

            $studentData["data"] = $assignmentTypeData;

            array_push($data, $studentData);

        }catch(\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }
        return response()->json(array('success' => true, 'data' => $data), 200);
    }


    public function editStudentsGrades($courseID, Request $request) {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            foreach($request->json() as $studentData) {
                $studentNumber = $studentData["studentNumber"];
                $grades = $studentData["data"];
                foreach ($grades as $grade) {
                   // return response()->json(array('sutudentNumber' =>$studentNumber , 'message' => $grade["assignmentID"], 'score' =>$grade["score"]), 200);
                    DB::table('assignmentscore')
                        ->where('studentNumber','=',$studentNumber)
                        ->where('assignmentID','=', $grade["assignmentID"])
                        ->update(['score' => $grade["score"]]);
                }
            }
        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }
        return response()->json(array('success' => true, 'message' => 'scores updated successfully'), 200);

    }

    public function getStudentByCourse($courseID)
    {
        try{
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $students = DB::table('student as s')
                ->join('course_student as c','s.studentNumber','=','c.studentNumber')
                ->select('s.studentNumber', 's.studentFName','s.studentLName','c.courseID')
                ->where('c.courseID','=',$courseID)->get();
        } catch(\Exception $ex)
        {
            return response()->json(array('success' => false, 'message' => $ex->getMessage()), 500);
        }

        return response()->json(array('success' => true, 'data' => $students), 200);

    }

    public function getAttendanceByCourse($courseID, Request $request){
        try{
            $currentTeacher = JWTAuth::parseToken()->authenticate();
//            $start = $request->get('startDate');
//            $end = $request->get('endDate');
            $attendance = DB::table('attendance')
                ->select('*')
                ->where([
                    ['courseID','=',$courseID],
                    ['studentNumber','=',$request->get('studentNumber') ]
                ])
                ->get();
        } catch(\Exception $ex)
        {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }

        return response()->json(array('success' => true, 'data' => $attendance), 200);
    }

    public function getAttendanceByID($studentNumber)
    {
        try{
            $currentTeacher = JWTAuth::parseToken()->authenticate();
//            $start = $request->get('startDate');
//            $end = $request->get('endDate');
            $attendance = DB::table('attendance')
                ->select('*')
                ->where(
                    'studentNumber','=',$studentNumber)

                ->get();
        } catch(\Exception $ex)
        {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }

        return response()->json(array('success' => true, 'data' => $attendance), 200);
    }


    public function getStudentsAttendance($courseID, Request $request){
        try{
            $currentTeacher = JWTAuth::parseToken()->authenticate();
//            $start = $request->get('startDate');
//            $end = $request->get('endDate');
            $attendance = DB::table('attendance')
                ->select('*')
                ->where('courseID','=',$courseID)
//                ->whereBetween('dateTaken',[$start, $end])
                ->get();
        } catch(\Exception $ex)
        {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }

        return response()->json(array('success' => true, 'data' => $attendance), 200);
    }

    public function storeStudentsAttendance($courseID, Request $request) {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $data = $request->get('data');
            $date = date_format(date_create($request->get('date')), "Y-m-d");
            foreach($data as $student) {
//                return response()->json(array('success' => true, 'message'=>$student["present"]), 200);
                DB::table('attendance')->insert([
                    'studentNumber' => $student["studentNumber"],
                    'student_present' => $student["present"],
                    'student_absent' => $student["absent"],
                    'student_tardy' => $student["tardy"],
                    'dateTaken' => $date,
                    'courseID' =>$courseID
                ]);


            }
        }catch(\Exception $ex)
        {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }
        return response()->json(array('success' => true, 'message'=>'store attendance successfully'), 200);

    }



    public function createAssignment(Request $request)
    {
        try {

        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }


    }

    public function assignTeacherToCourse(Request $request)
    {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            DB::table('course_teacher')
                ->insert(
                    [
                        "teacherID" =>$request->get('teacherID'),
                        "courseID" =>$request->get('courseID')
                    ]
                );


        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'error' => $ex->getMessage()), 500);
        }

        return response()->json(array('success' => true, 'message' => 'assigned successfully'), 200);

    }

    public function getTeachers()
    {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $teachers = DB::table('users')
                ->select('*')
                ->get();


        } catch (\Exception $ex) {
            return response()->json(array('success' => false, 'message' => $ex->getMessage()), 500);
        }

        return response()->json(array('success' => true, 'data' => $teachers), 200);
    }




    public function uploadSpellingCityData($studentNumber,Request $request)
    {
        try {

            $currentTeacher = JWTAuth::parseToken()->authenticate();

            $fileDir = 'F:/dataupload';
            $courseID = $request->get('courseID');
            $file = $request->file('dataFile');
            $file->move($fileDir,$file->getClientOriginalName());
            $uploadedFile = $fileDir.'/'.$file->getClientOriginalName();
            //$uploadedFile = 'F:/dataupload/spelling_city_student_activity.csv';
            $output = array_map('str_getcsv', file($uploadedFile, FILE_SKIP_EMPTY_LINES));
            $keys = array_shift($output);
            foreach ($output as $i=>$row) {
                $output[$i] = array_combine($keys, $row);

            }
            //return response()->json($output);
            foreach($output as $s) {
                DB::table('spellingcity_student_activity')
                    ->insert([
                        'list' => $s["List "],
                        'activity' => $s["Activity "],
                        'date' => date_format(date_create($s["Date "]), "Y-m-d H:i"),
                        'time_on_task' => $s["Time on Task "],
                        'score' => str_replace([' ', '%'],"", $s["Score "]),
                        'studentNumber' =>$studentNumber,
                        'courseID' =>$courseID
                    ]);
            }


        } catch(\Exception $ex) {
            return response()->json(array('success'=>'false','error' =>$ex->getMessage()), 404);
        }

        return response()->json(array('success'=>true, 'message'=>'data parsed successfully'));

    }

    public function getDataForSpellingCity($studentNumber, Request $request)
    {
        try {
            $currentTeacher = JWTAuth::parseToken()->authenticate();
            $data = DB::table('spellingcity_student_activity')
                ->select('*')
                ->where([
                    ['studentNumber', $studentNumber],
                    ['courseID', $request->get('courseID')]
                ])->get();
        }catch(\Exception $ex) {
            return response()->json(array('success'=>'false', 'error'=>$ex->getMessage()));
        }
        return response()->json(array('success'=>true, 'data'=>$data));


    }





}