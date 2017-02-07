<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $table = 'schoolyear';
    protected $primaryKey = 'schoolYearID';
    protected $fillable = [
      'startYear', 'endYear'
    ];
    // Return all the courses of a school year
    public function courses() {
        return $this->hasMany('App\Course', 'schoolYearID', 'schoolYearID');
    }
}
