<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class OdeljenjeDjak extends Model{
    protected $table = 'odeljenje_djak';
    protected $fillable = ['id_djak','id_odeljenje','updated_at','created_at'];
}