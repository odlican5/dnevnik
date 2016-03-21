<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Roditelji extends Model{
    protected $table = 'roditelji';
    protected $fillable = ['ime','prezime','id','email','username','password','odeljenja_id'];
}