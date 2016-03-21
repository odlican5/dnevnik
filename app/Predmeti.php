<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Predmeti extends  Model{
    protected $table = 'predmeti';
    protected $fillable = ['naziv','created_at','updated_at','skole_id'];
}