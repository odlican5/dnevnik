<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Semestar extends Model{
    protected $table = 'semestar';
    protected $fillable = ['semestar','od','do','id_skole'];
}