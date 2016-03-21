<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Poruke extends Model{
    protected $table = 'poruke';
    protected $fillable = ['poruka','created_at','updated_at','posiljalac_id','primalac_id','procitano'];
}