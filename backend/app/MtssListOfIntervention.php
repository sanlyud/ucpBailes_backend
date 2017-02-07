<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MtssListOfIntervention extends Model
{
    protected $table = 'mtsslistofinterventions';
    protected $primaryKey = 'listOfInterventionsID';
    public $timestamps = false;

    protected $fillable = [
        'subjectOrIssue', 'subjectIssueNotes','interventionSupportTier1', 'interventionSupportInterv',
        'interventionSupportSupport', 'interventionSupportChosenItem', 'interventionSupportNotes','personRespName',
        'personResPosition', 'frequencyDays', 'frequencyMinutes', 'dateIntervStarted', 'outcome'
    ];

    public function listOfInterventionsForm()
    {
        return $this->belongsTo('App\MtssListOfInterventionsFrom','listOfInterventionsFrmID', 'listOfInterventionsFrmID');
    }
}
