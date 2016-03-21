<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Korisnici;
use App\Predmeti;

use App\Izostanci;
use App\Djaci;
use App\OdeljenjeDjak;
use App\Odeljenja;
use App\Razredni;

use App\PravaPristupa;
use Illuminate\Http\Request;
use App\Security;
use App\Metode;
use Illuminate\Support\Facades\Session;

class IzostanciKontroler extends Controller {
	public function getIndex(){
	$odeljenje_id=Metode::razredni_provera(Session::get('id'));//niz 
		//dd($odeljenje_id);
	$izostanci=Izostanci::join('djaci','djaci.id','=','izostanci.djaci_id')
	->join('odeljenje_djak','odeljenje_djak.id_djak','=','djaci.id') 
	->join('odeljenja','odeljenja.id','=','odeljenje_djak.id_odeljenje')
	->where('odeljenja.nastavnici_id','=',Session::get('id'))
	->where('izostanci.opravdano','=','2')//2 je neravdano. 1 je pravdano , 0 je neopravdano
	->get(['izostanci.id','izostanci.broj_casova','izostanci.datum','djaci.ime','djaci.prezime','odeljenja.razred','odeljenja.odeljenje'])->toArray();
	
	return Security::autentifikacija('profesor-admin.izostanci',compact('izostanci'),3);
	}
	public function postPravdaj(){
		$podaci=json_decode(Input::get('podaci'));
		
		$id=$podaci->id;
		$opravdano=$podaci->opravdano;
		Izostanci::where('id',$id)->update(['opravdano'=>$opravdano]);
		return json_encode(['msg'=>'Успешно решен изостанак.','check'=>1]);
	}

}