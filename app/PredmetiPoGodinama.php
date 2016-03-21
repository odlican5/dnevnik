<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class PredmetiPoGodinama extends  Model{
    protected $table = 'predmeti_po_godinama';
    protected $fillable = ['id_godina','created_at','updated_at','id_predmeta','nastavnici_id'];
}