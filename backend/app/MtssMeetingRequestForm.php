<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MtssMeetingRequestForm extends Model
{
    // Explicitly declare the table name, primary key since we do not follow Laravel naming conventions
    protected $table = 'mtssmeetingrequestform';
    protected $primaryKey = 'meetingRequestFrmID';
    public $timestamps = false;

    public function masterForm()
    {
        return $this->belongsTo('App\MtssFormMaster','masterFormID', 'formMasterID');
    }
}
