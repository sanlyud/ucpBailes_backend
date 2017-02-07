<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::post('api/register', 'TokenAuthController@register');
//Route::post('api/authenticate', 'TokenAuthController@authenticate');
//Route::get('api/authenticate/user', 'TokenAuthController@getAuthenticatedUser');

Route::group(['prefix' => 'api'], function()
{
    Route::resource('authenticate', 'AuthenticateController', ['only' => ['index']]);
    Route::post('authenticate', 'AuthenticateController@authenticate');
    Route::post('login', 'AuthenticateController@login');
    Route::post('register', 'AuthenticateController@register');
////    Route::post('register', 'TokenAuthController@register');
////    Route::post('authenticate', 'TokenAuthController@authenticate');
////    Route::get('authenticate/user', 'TokenAuthController@getAuthenticatedUser');
});
Route::group([
    'prefix' => 'api2',
    'namespace' => 'Api'
], function() {
    Route::post('/auth/register/teacher', [
        'as' => 'auth.register',
        'uses' => 'AuthController@register'
    ]);

    Route::post('/auth/login', [
        'as' => 'auth.login',
        'uses' => 'AuthController@login'
    ]);

    Route::get('/home', [
        'as' => 'home.home',
        'uses' => 'HomeController@home'
    ]);
    Route::get('/auth/students', [
        'as' => 'auth.students',
        'uses' => 'TeacherController@index'
    ]);

    Route::post('/auth/student/create',[
        'as' => 'auth.student',
        'uses' => 'TeacherController@createStudent'
    ]);

    Route::get('/auth/student/{id?}', [
        'as' => 'auth.student',
        'uses' => 'TeacherController@showStudent'
    ]);
    Route::post('/auth/student/edit/{id?}', [
        'as' => 'auth.student',
        'uses' => 'TeacherController@editStudent'
    ]);

    Route::post('/auth/student/createMasterForm',[
        'as' => 'auth.student',
        'uses' => 'FormController@createMasterForm'
    ]);

    Route::post('/auth/student/getmasterform/{id?}',[
        'as' => 'auth.student',
        'uses' => 'FormController@getMasterForm'
    ]);

    Route::get('/auth/student/masterforms/{studentNumber?}',[
        'as' => 'auth.student',
        'uses' => 'FormController@getMasterForms'
    ]);

    Route::post('/auth/student/masterform/meetingrequestform',[
        'as' => 'auth.student',
        'uses' => 'FormController@createMtssMeetingRequestForm'
    ]);

    Route::get('/auth/student/masterform/{formid?}/meetingrequestform',[
        'as' => 'auth.student',
        'uses' => 'FormController@getMeetingRequestForm'
    ]);

    Route::post('/auth/student/masterform/{formid?}/meetingnotesform/create',[
        'as' => 'auth.student',
        'uses' => 'FormController@createMtssMeetingNotesForm'
    ]);

    Route::get('/auth/student/masterform/{formid?}/meetingnotesform',[
        'as' => 'auth.student',
        'uses' => 'FormController@getMtssMeetingNotesForm'
    ]);

    Route::post('/auth/student/masterform/{formid?}/meetinglogform/create',[
        'as' => 'auth.student',
        'uses' => 'FormController@createMtssMeetingLogForm'
    ]);

    Route::get('/auth/student/masterform/{formid?}/meetinglogform',[
        'as' => 'auth.student',
        'uses' => 'FormController@getMtssMeetingLogForm'
    ]);

    Route::post('/auth/student/masterform/{id}/listofinterventionsform/create',[
        'as' => 'auth.student',
        'uses' => 'FormController@createmtssListOfInterventionsForm'
    ]);

    Route::get('/auth/student/masterform/{formid?}/listofinterventionsforms',[
        'as' => 'auth.student',
        'uses' => 'FormController@getmtssListOfInterventionsForms'
    ]);

    Route::post('/auth/student/masterform/{id}/databaseddecisiontoolform/create',[
        'as' => 'auth.student',
        'uses' => 'FormController@createMtssDataBasedDecisionToolForm'
    ]);

    Route::get('/auth/student/masterform/{formid?}/databaseddecisiontoolforms',[
        'as' => 'auth.student',
        'uses' => 'FormController@getMtssDataBasedDecisionToolForms'
    ]);



    Route::post('/auth/course/create',[
        'as' => 'auth.course',
        'uses' => 'TeacherController@createCourse'
    ]);

    Route::post('/auth/course/edit/{id?}',[
        'as' => 'auth.course',
        'uses' => 'TeacherController@editCourse'
    ]);

    Route::get('/auth/course/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@showCourse'
    ]);

    Route::get('/auth/courses/', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getAllUnassignedCourses'
    ]);

    Route::post('/auth/course/search',[
        'as' => 'auth.course',
        'uses' => 'TeacherController@searchCourse'
    ]);
    Route::get('/auth/schoolyear', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getSchoolYears'
    ]);

    Route::get('/auth/students/grade/{id?}', [
        'as' => 'auth.student',
        'uses' => 'TeacherController@getStudentsAtGrade'
    ]);

    Route::get('/auth/courses/grade/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getCoursesAtGrade'
    ]);

    Route::post('/auth/courses/assign', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@assignCoursesToStudents'
    ]);

    Route::get('/auth/courses/category', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getCategories'
    ]);

    Route::get('/auth/grades/', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getGrades'
    ]);

    Route::post('/auth/courses/gradeandcategory', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getCoursesByGradeAndCat'
    ]);
    Route::get('/auth/teachers', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getTeachers'
    ]);

    Route::get('/auth/grades/course/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getStudentsGrades'
    ]);

    Route::post('/auth/grades/edit/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@editStudentsGrades'
    ]);

    Route::post('/auth/courses/assigntoteacher', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@assignTeacherToCourse'
    ]);

    Route::post('/auth/spellingcity/upload/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@uploadSpellingCityData'
    ]);

    Route::get('/auth/students/course/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getStudentByCourse'
    ]);

    Route::get('/auth/student/attendance/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getAttendanceByID'
    ]);

    Route::get('/auth/students/attendance/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getStudentsAttendance'
    ]);

    Route::post('/auth/students/attendance/store/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@storeStudentsAttendance'
    ]);

    Route::post('/auth/student/spellingcitydata/{id?}', [
        'as' => 'auth.course',
        'uses' => 'TeacherController@getDataForSpellingCity'
    ]);

});