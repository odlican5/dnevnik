<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Security;
use App\Metode;
use Illuminate\Support\Facades\Session;

use App\Nastavnici;


class ProfilKontroler extends Controller {
	
	public function getIndex(){
		$procenat_popunjenosti=$this->proverapopunjenostiprofila();
		$nastavnici=Nastavnici::where('id','=',Session::get('id'))->get(['id','ime','prezime','username','password','email','telefon']);
		return Security::autentifikacija('profesor-admin.profil',compact('nastavnici','procenat_popunjenosti'),3);
	}
	public function postEditNalog(){
		if(!Security::autentifikacijaTest(3,'min'))return Security::rediectToLogin();
		//pocetak validacije
		$data=Input::all();
		$rules = [
	        'username'	=> 'Required|Between:5,45|alpha_num',
	        'password'=>'min:4|alpha_num|confirmed',
	         'password_confirmation' => 'min:4|alpha_num|same:password',
	        'email'     => 'Between:3,64|Email',
	         'telefon'     => 'max:20',
			];
		$messages = [
        'username.required' => 'Попуните захтевана поља',
        'password.min:4' => 'Дужина лозине није одговарајућа',
        'password.confirmed' => 'Потврдите лозинку',
        'email.Email' => 'унесите одговарајући маил',
        ];
		$v=Validator::make($data,$rules,$messages);
		if($v->fails())
		{
			return Redirect::to('/administracija/profil')->withErrors($v->errors());
		}
		//kraj validacije

		$korisnik= Nastavnici::firstOrNew(['id'=>Input::get('id')],['id','prezime','ime' ,'username','password','email','telefon']);  
		$korisnik->prezime=Input::get('prezime');
		$korisnik->ime=Input::get('ime');
		$korisnik->username=Input::get('username');
		if(Input::get('password'))if(strlen(Input::get('password'))>4) $korisnik->password=Security::generateHashPass(Input::get('password'));
		$korisnik->email=Input::get('email');
		$korisnik->telefon=Input::get('telefon');
		$korisnik->save();
		return Redirect::back();
		
	}
	 private function proverapopunjenostiprofila(){
			$korisnik=Nastavnici::where('id',Session::get('id'))->get(['id','ime','prezime','email','username','telefon'])->first()->toArray();
			$counter = 0;
			foreach($korisnik as $key=>$value)
			{
			  if($value === null || $value==='')
			    $counter++;
				else{$popunjene_kolone[]=$key;}
			}
			$counter=5-$counter;
			$procenat_popunjenosti=round($counter/5*100,0);
			return $procenat_popunjenosti;
			return $popunjene_kolone;
    }
}