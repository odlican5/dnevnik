<?php namespace App;

use App\Poruke;
use App\Ocene;
use App\Odeljenja;
use App\Izostanci;
use Illuminate\Support\Facades\Session;
use Mail;
class Metode {
    public static function limit_text($text, $limit) {
      if (str_word_count($text, 0) > $limit) {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }
    public static function number_unread_messages(){
        return Poruke::where('primalac_id','=',Session::get('id'))
        ->where('procitano','=','0')->count();
    }
    public static function razredni_provera($id){//provera da li je razredni vraca true ili false
        $raz=Odeljenja::where('nastavnici_id','=',$id)->exists();      
        return $raz;
    }
    public static function razredni_odeljenje(){//provera da li je razredni vraca true ili false
        $razredni_odeljenje=Odeljenja::where('nastavnici_id','=',Session::get('id'))->pluck('id');      

        return $razredni_odeljenje;
    }
    public static function nove_ocene_provera($id){
      $info=Ocene::join('roditelji','roditelji.id','=','ocene.roditelji_id')
            ->join('predmeti','predmeti.id','=','ocene.id_predmeti')
            ->where('ocene.procitano','=',0)
            ->where('ocene.roditelji_id','=',$id)
            ->get(['ocene.id','ocene.ocene','ocene.created_at','predmeti.naziv','ocene.id_predmeti'])->toArray();
        if($info==0) {return 'Nemate novih ocena!';}
          else {
            return $info;

          }
    }
    public static function broj_neopravdanih($id){
          return Izostanci::join('djaci','djaci.id','=','izostanci.djaci_id')
          ->join('roditelji','roditelji.id','=','djaci.id_roditelji')
          ->where('roditelji.id','=',$id)->sum('izostanci.broj_casova');
    }
    public static function posalji_mail_izostanci($predmet,$broj_casova,$datum, $email){
      $data=[
        'predmet'=>$predmet,
        'broj_casova'=>$broj_casova,
        'datum'=>$datum
        ];
      Mail::send(['html'=>'emails.izostanak'], $data, function ($m) use ($email){
          $m->to($email, 'Saša Jović')->subject('Obaveštenje - Odličan5');
            });
    }
    public static function posalji_mail_roditelju($predmet,$nastavnik,$email,$poruka){
      $data=[
        'predmet'=>$predmet,
        'nastavnik'=>$nastavnik,
        'poruka'=>$poruka
        ];
      Mail::send(['html'=>'emails.poruka'], $data, function ($m) use ($email){
          $m->to($email, 'Saša Jović')->subject('Obaveštenje - Odličan5');
            });
    }

}