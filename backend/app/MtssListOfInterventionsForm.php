<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MtssListOfInterventionsForm extends Model
{
    protected $table = 'mtsslistofinterventionsform';
    protected $primaryKey = 'listOfInterventionsFrmID';
    public $timestamps = false;

    protected $fillable = [
        'masterFormID', 'teacherName', 'studentNumber','grade', 'date', 'notes'
    ];

    public function masterForm()
    {
        return $this->belongsTo('App\MtssFormMaster','masterFormID', 'formMasterID');
    }

    public function listOfInterventions()
    {
        return $this->hasMany('App\MtssListOfIntervention','listOfInterventionsFrmID','listOfInterventionsFrmID');
    }
}
