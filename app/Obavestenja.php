<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Obavestenja extends Model{
    protected $table = 'obavestenja';
    protected $fillable = ['id','naslov','obavestenje','url','created_at','updated_at'];
}