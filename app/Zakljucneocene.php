<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Zakljucneocene extends Model{
    protected $table = 'zakljucne_ocene';
    protected $fillable = ['zakljucna','predmeti_id','semestar_id','djaci_id'];
}