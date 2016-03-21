<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Djaci extends Model{
    protected $table = 'djaci';
    protected $fillable = ['id','aktivan','ime','prezime','id_razred','id_odeljenje','id_roditelji','created_at','updated_at','razred','odeljenje','razred_odeljenje','id_skole'];
}