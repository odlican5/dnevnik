<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Korisnici;
use App\Predmeti;
use App\PredmetiPoGodinama;
use App\PravaPristupa;
use App\VrstaKorisnika;
use Illuminate\Http\Request;
use App\Security;
use Illuminate\Support\Facades\Session;
use App\Ocene;
use App\Djaci;
use App\Roditelji;
use App\Odeljenja;
use Illuminate\Support\Facades\DB;
use App\Izostanci;
use App\Poruke;
use DateTime;
use Barryvdh\Debugbar\Facade;
use DebugBar\StandardDebugBar;
use App\Http\Controllers\App;
use App\Zakljucneocene;
use App\Semestar;

class RoditeljiKontroler extends Controller {
	public function getPregled(){
		/*$predmeti=PredmetiPoGodinama::join('predmeti','predmeti.id','=','predmeti_po_godinama.id_predmeta')
		->join('skole','skole.id','=','predmeti.skole_id')
		->where('skole.id','=',Session::get('skola_id'))
		->get(['predmeti_po_godinama.id','predmeti.naziv','predmeti.id as idpredmeta','predmeti_po_godinama.id_godina'])->toArray();
		//dd($ocene);*/
		$predmeti=Predmeti::join('skole','skole.id','=','predmeti.skole_id')
		->where('predmeti.skole_id','=',Session::get('skola_id'))
		->get(['predmeti.naziv','predmeti.id'])->toArray();

		$izostanci['neopravdano']=DB::table('izostanci')
				->join('djaci','djaci.id','=','izostanci.djaci_id')
					->join('roditelji','roditelji.id','=','djaci.id_roditelji')
					->where('roditelji.id','=',Session::get('id'))
					->where('izostanci.opravdano','=',0)
					->sum('broj_casova');
		$izostanci['ukupno']=Izostanci::
				join('djaci','djaci.id','=','izostanci.djaci_id')
					->join('roditelji','roditelji.id','=','djaci.id_roditelji')
					->where('roditelji.id','=',Session::get('id'))
					->sum('broj_casova');//2 je neravdano. 1 je pravdano , 0 je neopravdano
		$prosek=Zakljucneocene::join('djaci','djaci.id','=','zakljucne_ocene.djaci_id')
						->join('predmeti','predmeti.id','=','zakljucne_ocene.predmeti_id')
						->join('semestar','semestar.id','=','zakljucne_ocene.semestar_id')
						->join('roditelji','roditelji.id','=','djaci.id_roditelji')
						->where('djaci.id_roditelji','=',Session::get('id'))
						->where('zakljucne_ocene.semestar_id','=',1)
						->avg('zakljucna',2);

		return Security::autentifikacija('roditelj.pregled',compact('predmeti','izostanci','prosek'),2);
	}
	public function postUcitajPregled(){
		//ocene po predmetima $_POST['id']je id predmeti.id 
		$ocene['po_predmetima']=Ocene::join('predmeti','predmeti.id','=','ocene.id_predmeti')
		->join('nastavnici','nastavnici.predmeti_id','=','predmeti.id')
		->orderBy('ocene.created_at','desc')
		->where('ocene.id_predmeti','=',$_POST['id'])//dodati roditelji_id ako ima više dece u skoli
		->where('ocene.roditelji_id','=',Session::get('id'))
		->get(['predmeti.naziv','ocene.id','ocene.ocene','ocene.zapazanje','ocene.created_at','nastavnici.ime','nastavnici.prezime'])->toArray();
		//zakljucna ocena po predmetima
		$ocene['zakljucna_kraj']=Ocene::where('id_predmeti','=',$_POST['id'])
						->where('zakljucna','=',2)
						->where('roditelji_id','=',Session::get('id'))
						->get(['zakljucna','ocene','roditelji_id'])
						->toArray();
		$ocene['zakljucna_prvo']=Ocene::where('id_predmeti','=',$_POST['id'])
						->where('zakljucna','=',1)
						->where('roditelji_id','=',Session::get('id'))
						->get(['zakljucna','ocene','roditelji_id'])
						->toArray();
		if ($ocene['zakljucna_kraj']==null) {

		$ocene['zakljucna_kraj'] =[(object)['ocene'=>'Није закључена']];//пра
		}


		if ($ocene['zakljucna_prvo']==null) {
			$ocene['zakljucna_prvo'] = [(object)['ocene'=>'Није закључена']];
		}

						//dd($zakljucne);
		return json_encode($ocene);
	}
	public function postUcitajPreglednovi(){
		//ocene po predmetima $_POST['id']je id predmeti.id 
		$ocene['po_predmetima']=Ocene::join('predmeti','predmeti.id','=','ocene.id_predmeti')
		->where('ocene.id_predmeti','=',$_POST['predmet_id'])//dodati roditelji_id ako ima više dece u skoli
		->where('ocene.roditelji_id','=',Session::get('id'))->get(['predmeti.naziv','ocene.id','ocene.ocene','ocene.zapazanje','ocene.created_at'])->toArray();
		//zakljucna ocena po predmetima
				$ocene['zakljucna_kraj']=Ocene::where('id_predmeti','=',$_POST['predmet_id'])
						->where('zakljucna','=',2)
						->where('roditelji_id','=',Session::get('id'))
						->get(['zakljucna','ocene','roditelji_id'])
						->toArray();
		$ocene['zakljucna_prvo']=Ocene::where('id_predmeti','=',$_POST['predmet_id'])
						->where('zakljucna','=',1)
						->where('roditelji_id','=',Session::get('id'))
						->get(['zakljucna','ocene','roditelji_id'])
						->toArray();
		if ($ocene['zakljucna_kraj']==null) {

		$ocene['zakljucna_kraj'] =[(object)['ocene'=>'Није закључена']];//пра
		}


		if ($ocene['zakljucna_prvo']==null) {
			$ocene['zakljucna_prvo'] = [(object)['ocene'=>'Није закључена']];
		}
		Ocene::find($_POST['id'])->update(['procitano'=>'1']);
		return json_encode($ocene);
	}
	public function getIzostanci(){
		$djak=Djaci::where('id_roditelji','=',Session::get('id'))
		->get(['djaci.id'])->toArray();
		//dd($djak);
		$izostanci['ukupno']=Izostanci::where('djaci_id','=', $djak[0]['id'])
		->count();
		$izostanci['nepravdano']=Izostanci::where('djaci_id','=', $djak[0]['id'])
		->where('opravdano','=','0')->count();
		$izostanci['opravdano']=Izostanci::where('djaci_id','=', $djak[0]['id'])
		->where('opravdano','=','1')->count();
		$izostanci['neopravdano']=Izostanci::where('djaci_id','=', $djak[0]['id'])
		->where('opravdano','=','2')->count();

		return Security::autentifikacija('roditelj.izostanci',compact('izostanci'),2);
	}
	
	
}