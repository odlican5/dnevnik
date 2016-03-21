<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Raspored extends Model{
    protected $table = 'raspored';
    protected $fillable = ['skole_id','predmet','broj_casa','dan','created_at','updated_at','boja','boja_teksta'];
  
}