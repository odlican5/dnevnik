<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Ocene extends Model{
    protected $table = 'ocene';
    protected $fillable = ['ocene','created_at','updated_at',
    'korisnici_id','zapazanje',
    'id_djaci','id_predmeti_po_godinama','id_odeljenja','roditelji_id','id_predmeti','procitano','zakljucna'];
}