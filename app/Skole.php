<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Skole extends Model{
    protected $table = 'skole';
    protected $fillable = ['naziv','slug','aktivan','sediste','direktor','adresa','created_at','udated_at','korisnici_id','telefon','email'];
}