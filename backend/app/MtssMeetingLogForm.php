<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MtssMeetingLogForm extends Model
{
    protected $table = 'mtssmeetinglogform';
    protected $primaryKey = 'meetingLogFrmID';
    public $timestamps = false;

    protected $fillable = [
        'masterFormID', 'studentNumber'
    ];

    public function masterForm()
    {
        return $this->belongsTo('App\MtssFormMaster','masterFormID', 'formMasterID');
    }
    public function meetingLogs()
    {
        return $this->hasMany('App\MtssMeetingLog','meetingLogFrmID','meetingLogFrmID');
    }
}
