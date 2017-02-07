<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MtssMeetingLog extends Model
{
    protected $table = 'mtssmeetinglog';
    protected $primaryKey = 'mtssMeetingLogID';
    public $timestamps = false;

    protected $fillable = [
        'meetingLogFrmID', 'teacherFName', 'teacherLName','grade', 'meetingDate', 'meetingType'
    ];

    public function meetingLogForm()
    {
        return $this->belongsTo('App\MtssMeetingLogForm','meetingLogFrmID', 'meetingLogFrmID');
    }

    public function membersAttended()
    {
        return $this->hasMany('App\Mtssmemberattended','mtssMeetingLogID', 'mtssMeetingLogID');
    }
}
