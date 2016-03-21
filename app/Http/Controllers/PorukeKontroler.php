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
use Illuminate\Support\Facades\DB;
use App\Izostanci;
use App\Poruke;
use DateTime;
use Barryvdh\Debugbar\Facade;
use DebugBar\StandardDebugBar;
use App\Http\Controllers\App;

class PorukeKontroler extends Controller {
	public function getIndex(){
		//primalac_id je u ovom slučaju id djaka na koga se poruka odnosi a ne na roditelja
		$poruke['poslate']=Poruke::join('roditelji as r','r.id','=','poruke.primalac_id')
		->where('poruke.posiljalac_id',Session::get('id'))
		->orderby('poruke.created_at','DESC')
		->get(['poruke.id','poruke.poruka','poruke.created_at as datum','poruke.posiljalac_id','r.ime','poruke.procitano'])->toArray();
		
		$djaciroditelji=Djaci::join('roditelji as rod','rod.id','=','djaci.id_roditelji')
		->whereIn('djaci.id',function($query){
				$query->select('p.primalac_id')->from('poruke as p')->where('p.posiljalac_id','=',Session::get('id'));
		})
		->get(['rod.ime as imeroditelja','rod.prezime as prezimeroditelja','rod.id as idroditelja','djaci.ime as imedjaka'])->toArray();

		$poruke['primljene']=Poruke::join('roditelji as r','r.id','=','poruke.posiljalac_id')
		->where('poruke.primalac_id',Session::get('id'))
		->orderby('poruke.created_at','DESC')
		->get(['poruke.id','poruke.poruka','poruke.created_at as datum','poruke.primalac_id','r.ime','poruke.procitano'])->toArray();

		return Security::autentifikacija('profesor-admin.poruke',compact('poruke'),3);

	}
	public function getRoditelji(){
		//metoda za roditelje index
		//primalac_id je u ovom slučaju id djaka na koga se poruka odnosi a ne na roditelja
		$poruke['poslate']=Poruke::join('roditelji as r','r.id','=','poruke.primalac_id')
		->where('poruke.posiljalac_id',Session::get('id'))
		->orderby('poruke.created_at','DESC')
		->get(['poruke.id','poruke.poruka','poruke.created_at as datum','poruke.posiljalac_id','r.ime','poruke.procitano'])->toArray();
		
		$djaciroditelji=Djaci::join('roditelji as rod','rod.id','=','djaci.id_roditelji')
		->whereIn('djaci.id',function($query){
				$query->select('p.primalac_id')->from('poruke as p')->where('p.posiljalac_id','=',Session::get('id'));
		})
		->get(['rod.ime as imeroditelja','rod.prezime as prezimeroditelja','rod.id as idroditelja','djaci.ime as imedjaka'])->toArray();

		$poruke['primljene']=Poruke::join('roditelji as r','r.id','=','poruke.posiljalac_id')
		->where('poruke.primalac_id',Session::get('id'))
		->orderby('poruke.created_at','DESC')
		->get(['poruke.id','poruke.poruka','poruke.created_at as datum','poruke.primalac_id','r.ime','poruke.procitano'])->toArray();

		return Security::autentifikacija('roditelj.poruke',compact('poruke'),2);
		
	}
	public function postCurrentMessage(){
			$poruka=Poruke::where('poruke.posiljalac_id',Session::get('id'))
			->where('id',$_POST['id'])
			->get(['poruke.id','poruke.poruka','poruke.created_at as datum','poruke.posiljalac_id','poruke.procitano'])->toArray();
			return json_encode($poruka);
	}
	public function postPrimljene(){
			Poruke::where('poruke.primalac_id',Session::get('id'))
			->where('id',$_POST['id'])
			->update(['poruke.procitano'=>1]);

			$poruka=Poruke::where('poruke.primalac_id',Session::get('id'))
			->where('id',$_POST['id'])
			->get(['poruke.id','poruke.poruka','poruke.created_at as datum','poruke.posiljalac_id','poruke.procitano'])->toArray();
			return json_encode($poruka);

	}
	public function postObrisiPoruku(){
		Poruke::where('id','=',$_POST['id'])->delete();
		return;
	}
	public function postPosaljimail(){
		$podaci=json_decode(Input::get('podaci'));
		//upisuje se id roditelja kao prijem
		//$idroditelja=Roditelji::join('djaci','djaci.id_roditelji','=','roditelji.id')
		//->where('djaci.id_roditelji','=',$podaci->iddjaka)
		//->get(['roditelji.id as ids','roditelji.ime'])->first();

		if($podaci->poruka!==''){
			$message=new Poruke();
			$message->poruka=$podaci->poruka;
			$message->posiljalac_id=Session::get('id');
			$message->primalac_id=$podaci->messageID;
			$message->save();
			return json_encode(['msg'=>'Uspešno ste poslali poruku.','check'=>1]);	
		}return json_encode(['msg'=>'Greška! Niste uneli poruku.','check'=>0]);
		
	}
}
/*->whereIn('s.id',function($query){
				$query->select('r.smestaj_id')->from('rezervacije as r')->where('r.od','<=',date('Y-m-d'))->where('r.do','>',date('Y-m-d'));
			})*/