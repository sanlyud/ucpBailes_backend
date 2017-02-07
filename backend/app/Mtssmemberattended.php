<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mtssmemberattended extends Model
{
    protected $table = 'mtssmembersattended';
    protected $primaryKey = 'membAttendedID';
    public $timestamps = false;

    protected $fillable = [
        'mtssMeetingLogID', 'name', 'position'
    ];

    public function meetingLog()
    {
        return $this->belongsTo('App\MtssMeetingLog','mtssMeetingLogID', 'mtssMeetingLogID');
    }
}
