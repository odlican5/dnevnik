<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Dogadjaji extends Model{
    protected $table = 'dogadjaji';
    protected $fillable = ['dogadjaj','datum','status','created_at','updated_at'];
}