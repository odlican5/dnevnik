<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Nastavnici extends Model{
    protected $table = 'nastavnici';
    protected $fillable = ['ime','prezime','username','password','token','created_at','updated_at','skole_id','telefon'];
  
}