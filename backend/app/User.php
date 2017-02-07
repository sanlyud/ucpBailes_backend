<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'schoolID', 'email', 'password','firstName', 'lastName'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Return all the students associated with the teacher
    public function students() {
        return $this->belongsToMany('App\Student','teacher_student', 'teacher_id', 'studentNumber');
    }

    public function courses() {
        return $this->belongsToMany('App\Course','course_teacher', 'teacherID', 'courseID');
    }
}
