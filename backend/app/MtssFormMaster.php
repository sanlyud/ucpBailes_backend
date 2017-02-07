<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MtssFormMaster extends Model
{
    /*
     * The table associated with the Model
     * timestamp attribute
     * primary key
     * @var string
     * @var string
     * @var bool
     */
    // Explicitly declare the table name, primary key since we do not follow Laravel naming conventions
    protected $table = 'mtssformmaster';
    protected $primaryKey = 'formMasterID';

    /**
     * Get the student for which this form is created for
     */
    public function student()
    {
        return $this->belongsTo('App\Student','studentNumber', 'studentNumber');
    }

    public function mtssMeetingRequestForms()
    {
        return $this->hasMany('App\MtssMeetingRequestForm','masterFormID', 'formMasterID');
    }
}
