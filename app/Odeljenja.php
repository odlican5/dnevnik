<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Odeljenja extends Model{
    protected $table = 'odeljenja';
    protected $fillable = ['id','razred','odeljenje','created_at','odeljenje_id','updated_at','nastavnici_id'];
}