<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table 	= 'students';

    protected $fillable	= ['name', 'address','age','grade_id'];

    public function grade()
    {
    	return $this->belongsTo('App\Grade');
    }
}
