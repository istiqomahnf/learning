<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grade';
  
    protected $fillable = ['grade','updated_at', 'created_at'];

    public function student(){
    	return $this->hasMany('App\Student');
    }
}
