<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Izostanci extends Model{
    protected $table = 'izostanci';
    protected $fillable = ['broj_casova','datum','created_at','updated_at','djaci_id','opravdano','procitano'];
}