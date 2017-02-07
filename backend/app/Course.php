<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = 'course';
    protected $primaryKey = 'courseID';
    protected $fillable = [
        'courseName', 'isActive', 'gradeID', 'categoryID', 'schoolYearID'
    ];

    public function schoolYear() {
        return $this->belongsTo('App\SchoolYear','schoolYearID', 'schoolYearID');
    }

    public function students()
    {
        return $this->belongsToMany('App\Course', 'course_student','courseID', 'studentNumber');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Course', 'course_teacher','courseID', 'teacherID');
    }


}
