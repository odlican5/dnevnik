<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class NastavniciOdeljenja extends Model{
    protected $table = 'nastavnici_odeljenja';
    protected $fillable = ['odeljenja_id','nastavnici_id','created_at','updated_at'];
  
}