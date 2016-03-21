<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Korisnici extends  Model{
    protected $table = 'korisnici';
    protected $fillable = ['username','password','prava_pristupa_id','mesto','adresa','created_at','updated_at','grad','token','aktivan','prezime','ime','email','telefon','opis','naziv'];
}