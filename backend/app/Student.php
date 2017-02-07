<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student';
    protected $primaryKey = 'studentNumber';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'schoolID', 'gradeID', 'studentDOB','studentFName', 'studentLName', 'studentMName'
    ];
    /**
     * The teachers that belong to the student
     */
    public function teachers()
    {
        return $this->belongsToMany('App\User','teacher_student','studentNumber','teacher_id');
    }
    public function masterForms()
    {
        return $this->hasMany('App\MtssFormMaster', 'studentNumber', 'studentNumber');
    }

    public function attendances() {
        return $this->hasMany('App\Attendance', 'studentNumber', 'studentNumber');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'course_student','studentNumber', 'courseID');
    }


}
