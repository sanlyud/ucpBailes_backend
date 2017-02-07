<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MtssDataBasedDecisionToolForm extends Model
{
    protected $table = 'mtssdatabaseddecisiontoolform';
    protected $primaryKey = 'dataBasedDecisionToolFrmID';
    public $timestamps = false;

    protected $fillable = [
        'masterFormID', 'meetingDate', 'AYPsubgroups','IDnumber', 'Retentions', 'A1', 'A2', 'B1', 'B2', 'B4',
        'stateLevelAssesments', 'stateLevelStudentScore', 'stateLevelAgeGroupScore', 'districtLevelAssesments','districtLevelStudentScore',
        'districtLevelAgeGroupScore','schoolLevelAssesments', 'schoolLevelStudentScore','schoolLevelAgeGroupScore', 'classLevelAssesments',
        'classLevelStudentScore', 'classLevelAgeGroupScore','subgroupLevelAssesments', 'subgroupLevelStudentScore',
        'subgroupLevelAgeGroupScore', 'cultureEthnFactors','irregAttendanceHighMobilFactors', 'limitedEnglishFactors',
        'chronologicalAgeFactors', 'genderFactors'
    ];

    public function masterForm()
    {
        return $this->belongsTo('App\MtssFormMaster','masterFormID', 'formMasterID');
    }
}
