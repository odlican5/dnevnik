<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Korisnici;
use App\Predmeti;
use App\PravaPristupa;
use App\VrstaKorisnika;
use Illuminate\Http\Request;
use App\Security;
use Illuminate\Support\Facades\Session;
use App\Ocene;
use App\Djaci;
use App\Roditelji;
use App\Odeljenja;
use App\NastavniciOdeljenja;
use Illuminate\Support\Facades\DB;
use App\Izostanci;
use App\Poruke;
use App\Nastavnici;
use App\OdeljenjeDjak;
use DateTime;
use Barryvdh\Debugbar\Facade;
use DebugBar\StandardDebugBar;
use App\Http\Controllers\App;
use Mail;
use App\Metode;

class OceneKontroler extends Controller {
	public function getIndex(){
		$ocene_predmeti['predmeti']=Predmeti::join('nastavnici','nastavnici.predmeti_id','=','predmeti.id')
		->where('nastavnici.id','=',Session::get('id'))->get(['predmeti.naziv','predmeti.id'])->toArray();
		$ocene_predmeti['ocene']=Ocene::join('djaci','djaci.id','=','ocene.id_djaci')->get(['ocene.ocene','ocene.created_at','djaci.ime','djaci.prezime'])->toArray();		
		/*$djaci=Djaci::join('skole','skole.id','=','djaci.id_skole')
			->where('skole.id','=',Session::get('skola_id'))
			->get(['djaci.id','djaci.ime','djaci.prezime','djaci.id_odeljenje','djaci.id_roditelji'])->toArray();
		*/


		//$odeljenja=Djaci::where('id_skole','=',Session::get('skola_id'))->groupBy('razred_odeljenje')->lists('razred_odeljenje', 'id');
		$razred_odeljenje=NastavniciOdeljenja::join('odeljenja','odeljenja.id','=','nastavnici_odeljenja.odeljenja_id')
		->where('nastavnici_odeljenja.nastavnici_id',Session::get('id'))
		->select(DB::raw("CONCAT(odeljenja.razred, ' razred/', odeljenja.odeljenje, ' odeljenje ') as raz_od,odeljenja.id as ids"))
		->groupBy('raz_od')->lists('raz_od','ids');
		//dd($razred_odeljenje);
		return Security::autentifikacija('profesor-admin.ocene-unos',compact('ocene_predmeti','djaci','odeljenje','razred','razred_odeljenje'),3);
	}
	public function postOdsutnost(){
		$podaci=json_decode(Input::get('podaci'));

		if($podaci->brojcasova =='' || $podaci->datum  ==''){
			return json_encode(['msg'=>'Нисте унели број часова или дадум!','check'=>0]);
		
		}else {
			$izostanak = new Izostanci();
			$izostanak->broj_casova=$podaci->brojcasova;
			$datum = new DateTime($podaci->datum);
			$izostanak->datum=date_format($datum,"Y-m-d");
			$izostanak->djaci_id=$podaci->djak_id;
			$izostanak->save();
			//za slanje maila
			$email=Djaci::join('roditelji','roditelji.id','=','djaci.id_roditelji')
			->where('djaci.id','=',$podaci->djak_id)
			->pluck('email');

			$predmet=Nastavnici::join('predmeti','predmeti.id','=','nastavnici.predmeti_id')
				->where('nastavnici.id','=',Session::get('id'))
				->pluck('naziv');

			$bc=$podaci->brojcasova;
			$dat=date_format($datum,"Y-m-d");
			Metode::posalji_mail_izostanci($predmet,$bc,$dat, $email);
			return json_encode(['msg'=>'Успешан унос изостанка.','check'=>1]);
		}
	}
	public function postUcitajDjake(){
		$id=Input::get('id');//id je odeljenja.id
		return json_encode(Djaci::join('odeljenje_djak','odeljenje_djak.id_djak','=','djaci.id')
					->join('odeljenja','odeljenja.id','=','odeljenje_djak.id_odeljenje')
					->where('djaci.id_skole','=',Session::get('skola_id'))
					->where('odeljenja.id','=',$id)
					->get(['djaci.id','djaci.prezime','djaci.ime'])
					->toArray());
					
					
	}
	public function postUcitajForm(){
		//http://stackoverflow.com/questions/8373315/is-there-a-way-to-pass-multiple-arrays-to-php-json-encode-and-parse-it-with-jque
		$djaci['djaci']=Djaci::find($_POST['id']);
		$djaci['ocene']=Djaci::join('ocene','ocene.id_djaci','=','djaci.id')
			->orderBy('ocene.created_at','desc')
			->where('djaci.id','=',$_POST['id'])->get()->toArray();
		
		$djaci['zakljucna_polugodiste']=Djaci::join('ocene','ocene.id_djaci','=','djaci.id')
			->where('djaci.id','=',$_POST['id'])
			->where('ocene.zakljucna','=',1)
			->get(['ocene.ocene'])->toArray();

		$djaci['zakljucna_kraj']=Djaci::join('ocene','ocene.id_djaci','=','djaci.id')
			->where('djaci.id','=',$_POST['id'])
			->where('ocene.zakljucna','=',2)
			->get(['ocene.ocene'])->toArray();

		if (!Djaci::join('ocene','ocene.id_djaci','=','djaci.id')
			->where('djaci.id','=',$_POST['id'])
			->where('ocene.zakljucna','=',1)->exists()) {
			$djaci['zakljucna_polugodiste']=[array('ocene'=>'Оцена није закључена')];
		}
		if (!Djaci::join('ocene','ocene.id_djaci','=','djaci.id')
			->where('djaci.id','=',$_POST['id'])
			->where('ocene.zakljucna','=',2)->exists()) {
					$djaci['zakljucna_kraj']=[array('ocene'=>'Оцена није закључена')];
				}
	//dodati ovde za izostanke
		$djaci['opravdano']=Izostanci::where('djaci_id','=',$_POST['id'])
			->where('opravdano','=',1)
			->sum('broj_casova');
		$djaci['neopravdano']=Izostanci::where('djaci_id','=',$_POST['id'])
		->where('opravdano','=',0)
		->sum('broj_casova');
		$djaci['nereseno']=Izostanci::where('djaci_id','=',$_POST['id'])
		->where('opravdano','=',2)
		->sum('broj_casova');
		return json_encode($djaci);
		//return json_encode(Djaci::join('ocene','ocene.id_djaci','=','djaci.id')->where('djaci.id','=',$_POST['id'])->get());
	}
	public function postSacuvaj(){
		$podaci=json_decode(Input::get('podaci'));

		if(!$podaci->ocena || !$podaci->zapazanje){return json_encode(['msg'=>'Унесите оцену и запажање.','check'=>0]);}

		if($podaci->update_id==1){
			Ocene::where('id','=',$podaci->ocene_id)->update(['ocene'=>$podaci->ocena,'zapazanje'=>$podaci->zapazanje,'zakljucna'=>$podaci->zakljucna]);
			return json_encode(['msg'=>'Успешно ажурирање.','check'=>1]);
		}
		if($podaci->update_id==false){ 

			$djaci=Djaci::where('djaci.id','=',$podaci->id)->get(['djaci.id_roditelji'])->toArray();
			$id_odeljenja=OdeljenjeDjak::where('id_djak','=',$podaci->id)->get(['odeljenje_djak.id'])->toArray();
			$predmeti_id=Nastavnici::where('nastavnici.id','=',Session::get('id'))
						->get(['nastavnici.predmeti_id'])->toArray();			
			$ocene = new Ocene();
			$ocene->id_djaci=$podaci->id;
			$ocene->ocene=$podaci->ocena;
			$ocene->zapazanje=$podaci->zapazanje;
			$ocene->id_odeljenja=$id_odeljenja[0]['id'];
			$ocene->roditelji_id=$djaci[0]['id_roditelji'];
			$ocene->id_predmeti=$predmeti_id[0]['predmeti_id'];
			$ocene->zakljucna=$podaci->zakljucna;
			$ocene->save();

			//slanje maila roditelju
			$predmet=Predmeti::where('id',$predmeti_id[0]['predmeti_id'])->pluck('naziv');
			$doditelj_email=Roditelji::where('id',$djaci[0]['id_roditelji'])->pluck('email');
			$datum=$ocene->created_at;
			$data=[
				'predmet'=>$predmet,
				'napomena'=>$podaci->zapazanje,
				'ocena'=>$podaci->ocena,
				'datum'=>$datum
			];
			$djaci_id_roditelja=Djaci::where('djaci.id','=',$podaci->id)->pluck('id_roditelji');
			$roditelj_email=Roditelji::where('id','=',$djaci_id_roditelja)->pluck('email');
			if($doditelj_email!=NULL){//провера да ли родитељ има маил ако да шаље га
				Mail::send(['html'=>'emails.obavestenje'], $data, function ($m) use ($roditelj_email){
					$m->to($roditelj_email, 'Saša Jović')->subject('Obaveštenje - Odličan5');
	        	});
	        	if( count(Mail::failures()) == 0 ) {
				    Ocene::where('ocene.id','=',$ocene->id)->update(['poslato'=>1]);
				}
			}
			return json_encode(['msg'=>'Успешно!','check'=>1]);
		}
	}
	public function postBrisi(){
		$podaci=json_decode(Input::get('podaci'));
		Ocene::where('id','=',$podaci->ocene_id)->delete();
		return json_encode(['msg'=>'Успешно брисање оцене.','check'=>1]);
	}
	public function postPosaljimail(){
		$podaci=json_decode(Input::get('podaci'));
		
		//upisuje se id roditelja kao prijem
		$idroditelja=Djaci::join('roditelji','roditelji.id','=','djaci.id_roditelji')
					->where('djaci.id','=',$podaci->iddjaka)
					->get(['roditelji.id as ids'])->toArray();

		if($podaci->poruka!=='')
		{
			if($podaci->svi == true)
			{//slanje maila svim roditeljima iz odeljenja
				$id_odeljenja=Odeljenja::where('nastavnici_id',Session::get('id'))->pluck('id');
				$emails=Djaci::join('odeljenje_djak','odeljenje_djak.id_djak','=','djaci.id')
					->join('odeljenja','odeljenja.id','=','odeljenje_djak.id_odeljenje')
					->leftJoin('roditelji',function($join){
						$join->on('djaci.id_roditelji','=','roditelji.id');
					})
					->where('odeljenja.id','=',$id_odeljenja)
					->where('djaci.id_skole','=',Session::get('skola_id'))
					->where('djaci.aktivan',1)
					->get(['roditelji.email as email_roditelja'])
					->toArray();
				foreach ($emails as $email) {
					$naziv_predmeta='biologija';
					$ime_nastavnika='marko';
					$por=$podaci->poruka;
					Metode::posalji_mail_roditelju($naziv_predmeta,$ime_nastavnika,$email['email_roditelja'],$por);
				}

				return json_encode(['msg'=>'Сви родитељи.','check'=>1]);
			}
		  	else
		  		{
					$message=new Poruke();
					$message->poruka=$podaci->poruka;
					$message->posiljalac_id=Session::get('id');
					$message->primalac_id=$idroditelja[0]['ids'];
					$message->save();
					
					$email=Djaci::join('roditelji','roditelji.id','=','djaci.id_roditelji')
					->where('djaci.id_roditelji','=',$idroditelja[0]['ids'])
					->pluck('email');

					$pr=Nastavnici::join('predmeti','predmeti.id','=','nastavnici.predmeti_id')
						->where('nastavnici.id','=',Session::get('id'))
						->get(['predmeti.naziv'])->toArray();

					$ime=Nastavnici::join('predmeti','predmeti.id','=','nastavnici.predmeti_id')
						->where('nastavnici.id','=',Session::get('id'))
						->get(['nastavnici.ime'])->toArray();
					
					$naziv_predmeta=$pr[0]['naziv'];
					$ime_nastavnika=$ime[0]['ime'];
					$por=$podaci->poruka;	

					Metode::posalji_mail_roditelju($naziv_predmeta,$ime_nastavnika,$email,$por);
					return json_encode(['msg'=>'Успешно сте послали поруку.','check'=>1]);	
				}
		}return json_encode(['msg'=>'Грешка! Нисте унели поруку!','check'=>0]);
		
	}
}