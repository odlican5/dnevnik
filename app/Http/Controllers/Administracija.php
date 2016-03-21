<?php namespace App\Http\Controllers;


use App\Security;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use App\Skole;
use App\Roditelji;
use App\Nastavnici;
use App\Predmeti;
use App\Odeljenja;
use App\NastavniciOdeljenja;
use App\Obavestenja;

class Administracija extends Controller {
	public function getLogin(){
		if(Security::autentifikacijaTest(2,'min')){
			return redirect('/administracija');
		}
		return view('log.login');
	}
	public function postLogin(){
		$tip_korisnika=Input::get('tip_korisnika');
		//dd($tip_korisnika);
		//dd($tip_korisnika);

		switch ($tip_korisnika) {
			case 'administrator':
				$redirect=Security::login(Input::get('username'),Input::get('password'),'Korisnici');
				break;
			case 'nastavnik':
				$redirect=Security::login(Input::get('username'),Input::get('password'),'Nastavnici');
				break;
			case 'roditelj':
				$redirect=Security::login(Input::get('username'),Input::get('password'),'Roditelji');
				break;
			
			default:
				# code...
				break;
		}

		

			//Session::put('prava_pristupa',Korisnici::find(Session::get('id'),['prava_pristupa_id'])->prava_pristupa_id);
			if(Session::get('prava_pristupa')==2 || Session::get('prava_pristupa')==3 || Session::get('prava_pristupa')==4 ||Session::get('prava_pristupa')==5  ) {
				switch (Session::get('prava_pristupa')) {			
					case '2':
					$skola=Roditelji::join('skole','skole.id','=','roditelji.skole_id')
					->where('roditelji.id','=',Session::get('id'))->get(['roditelji.skole_id','skole.slug'])->first();
					if($skola) Session::put('skola', $skola->slug);
					if($skola) Session::put('skola_id', $skola->skole_id);
							Session::put('tip', 'Roditelji');
						break;
					case '3':
					$skola=Nastavnici::join('skole','skole.id','=','nastavnici.skole_id')
					->where('nastavnici.id','=',Session::get('id'))->get(['nastavnici.skole_id','skole.slug'])->first();
					if($skola) Session::put('skola', $skola->slug);
					if($skola) Session::put('skola_id', $skola->skole_id);
						break;
					case '4':
						$skola=Skole::where('korisnici_id',Session::get('id'))->get(['skole.id','skole.slug'])->first();
						 Session::put('skola', $skola->slug);
						 Session::put('skola_id', $skola->id);
						break;
						case '5':
						$skola=Skole::where('korisnici_id',Session::get('id'))->get(['id','slug'])->first();
					if($skola) Session::put('skola', $skola->slug);
					if($skola) Session::put('skola_id', $skola->id);
						break;
					default:
						# code...
						break;
				}
				
			}
		return $redirect;
	}
	public function getLogout(){
		return Security::logout();
	}
	public function getIndex(){

				
				//$predmeti_id=Nastavnici::where('skole_id',Session::get('skola_id'))->get(['nastavnici.predmeti_id'])->toArray();
				//$predmeti=Predmeti::whereIn('predmeti.id',$predmeti_id)
				$predmeti=Predmeti::where('skole_id',Session::get('skola_id'))->lists('predmeti.naziv','predmeti.id');
				$nastavnici=Nastavnici::where('nastavnici.skole_id','=',Session::get('skola_id'))
				->get([DB::raw("CONCAT(nastavnici.ime, ' ', nastavnici.prezime, ' ') as ime_prezime"),'nastavnici.id'])
				->lists('ime_prezime','id');//lista nastavnika 
			;
/*->lists('ime','id');*/
				$razredi=Odeljenja::join('nastavnici','nastavnici.id','=','odeljenja.nastavnici_id')
				->where('nastavnici.skole_id',Session::get('skola_id'))
				->select(DB::raw("CONCAT(odeljenja.razred, ' razred/', odeljenja.odeljenje, ' odeljenje ') as raz_od,odeljenja.id"))
				->groupBy('raz_od')->lists('raz_od','id');		
				$arr=array();
				
				$slug=Skole::where('korisnici_id','=',Session::get('id'))->get(['slug'])->toArray();

			  $obavestenja= Obavestenja::where('id_skole','=',Session::get('skola_id'))
			  	->orderBy('created_at','DESC')
			  	->get(['id','obavestenje','url','created_at','naslov'])->toArray();
				//dd(Session::get('skola'));
			  
		switch(Session::get('prava_pristupa')){	

			case 2: return Security::autentifikacija('roditelj.index',compact('obavestenja'),2);//'Roditelj';
			case 3:  return Security::autentifikacija('profesor-admin.index',compact('obavestenja'),3);
			case 4: return Security::autentifikacija('skolski-admin.index',compact('predmeti','nastavnici','razredi'),4);
			case 5: return Security::autentifikacija('super-admin.index',null,5);
		}
		return redirect('/administracija/login');

	}
	
}
