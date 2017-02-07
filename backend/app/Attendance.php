<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    protected $fillable = [
        'studentNumber', 'student_absent', 'student_present', 'student_tardy', 'dateTaken'
    ];
    public function student()
    {
        return $this->belongsTo('App\Student', 'studentNumber', 'studentNumber');
    }
}
