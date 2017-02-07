<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MtssMeetingNoteForm extends Model
{
    protected $table = 'mtssmeetingnotesform';
    protected $primaryKey = 'mtssMeetingNotesFrmID';
    public $timestamps = false;

    public function masterForm()
    {
        return $this->belongsTo('App\MtssFormMaster','masterFormID', 'formMasterID');
    }
}
