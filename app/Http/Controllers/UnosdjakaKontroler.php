<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use DB;

use App\Security;
use App\Djaci;
use App\Odeljenja;
use App\OdeljenjeDjak;
use App\Roditelji;

class UnosdjakaKontroler extends Controller {
	public function getIndex(){	
		//djaci za unos roditelja za padajući meni u tabu rodidtelji
		$id_odeljenja=Odeljenja::where('nastavnici_id',Session::get('id'))->pluck('id');
		//DB::raw("CONCAT(odeljenja.razred, ' razred/', odeljenja.odeljenje, ' odeljenje ') as raz_od,odeljenja.id")		
		$roditelji_lista=Roditelji::join('odeljenja','odeljenja.id','=','roditelji.odeljenja_id')
					->where('odeljenja.id','=',$id_odeljenja)
					->where('roditelji.skole_id','=',Session::get('skola_id'))
					->select(DB::raw("CONCAT(roditelji.prezime, ' ', roditelji.ime) as prezime_ime, roditelji.id"))
					->lists('prezime_ime','id');
		return Security::autentifikacija('profesor-admin.unosdjaka',compact('roditelji_lista'),3);
	}
	public function postNovidjak(){
		if($_POST['update_djak']==false){
			$iddjaka=DB::table('djaci')->insertGetId(
				['ime'=>Input::get('djak_ime'),
					'prezime'=>Input::get('djak_prezime'),
					'id_skole'=>Session::get('skola_id'),
					'id_roditelji'=>Input::get('roditelji')
				]
				);
			$id_odeljenja=Odeljenja::where('nastavnici_id',Session::get('id'))->pluck('id');//id odeljenja gde je nastavnik razredni
			$odeljenje_djak=new OdeljenjeDjak();
			$odeljenje_djak->id_djak=$iddjaka;
			$odeljenje_djak->id_odeljenje=$id_odeljenja;
			$odeljenje_djak->save();
			return Redirect::back()->withErrors('Успешно унето!');
		}else{
			Djaci::where('id',$_POST['djak_id'])->update(['ime'=>$_POST['djak_ime'],'prezime'=>$_POST['djak_prezime']]);
			return Redirect::back()->withErrors('Успешно ажурирано!');
		}
	}public function postNoviroditelj(){
		if($_POST['update_roditelj']==false){
			$id_odeljenja=Odeljenja::where('nastavnici_id',Session::get('id'))->pluck('id');
			$idroditelja=DB::table('roditelji')->insertGetId(
				[
					'ime'=>Input::get('roditelj_ime'),
					'prezime'=>Input::get('roditelj_prezime'),
					'skole_id'=>Session::get('skola_id'),
					'odeljenja_id'=>$id_odeljenja,
					'username'=>Input::get('korisnicko_ime'),
					'password'=>Security::generateHashPass(Input::get('korisnicko_ime')),
					'aktivan'=>1, 
					'prava_pristupa_id'=>2
				]);
			return Redirect::back()->withErrors('Успешно унето!');
		}else{
			Roditelji::where('id',$_POST['roditelj_id'])->update(['ime'=>$_POST['roditelj_ime'],'prezime'=>$_POST['roditelj_prezime'],'username'=>Input::get('korisnicko_ime'),'password'=>Security::generateHashPass(Input::get('korisnicko_ime'))]);
			return Redirect::back()->withErrors('Успешно ажурирано!');
		}
	}
	public function postUcitajdjake(){
		$id_odeljenja=Odeljenja::where('nastavnici_id',Session::get('id'))->pluck('id');
		return json_encode(
			/*Djaci::join('odeljenje_djak','odeljenje_djak.id_djak','=','djaci.id')
					->join('odeljenja','odeljenja.id','=','odeljenje_djak.id_odeljenje')
					->leftJoin('roditelji',function($join){
						$join->on('djaci.id_roditelji','=','roditelji.id');
					})
					->where('odeljenja.id','=',$id_odeljenja)
					->where('djaci.id_skole','=',Session::get('skola_id'))
					->where('djaci.aktivan',1)
					->get(['djaci.id','djaci.prezime','djaci.ime','odeljenje_djak.id as ddd','roditelji.ime as ime_roditelja','roditelji.prezime as prezime_roditelja'])
					->toArray()*/
			Djaci::join('odeljenje_djak','odeljenje_djak.id_djak','=','djaci.id')
					->join('odeljenja','odeljenja.id','=','odeljenje_djak.id_odeljenje')
					->leftJoin('roditelji',function($join){
						$join->on('djaci.id_roditelji','=','roditelji.id');
					})
					->where('djaci.id_skole','=',Session::get('skola_id'))
					->where('odeljenja.id','=',$id_odeljenja)
					
					->get(['djaci.id','djaci.prezime','djaci.ime','odeljenje_djak.id as ddd','roditelji.ime as ime_roditelja','roditelji.prezime as prezime_roditelja'])
					->toArray()

					);
		

	}
	public function postUcitajroditelje(){
		$id_odeljenja=Odeljenja::where('nastavnici_id',Session::get('id'))->pluck('id');
		//DB::raw("CONCAT(odeljenja.razred, ' razred/', odeljenja.odeljenje, ' odeljenje ') as raz_od,odeljenja.id")		
		return json_encode(
			Roditelji::join('djaci','djaci.id_roditelji','=','roditelji.id')
					->join('odeljenje_djak','odeljenje_djak.id_djak','=','djaci.id')
					->join('odeljenja','odeljenja.id','=','odeljenje_djak.id_odeljenje')
					->where('odeljenja.id','=',$id_odeljenja)
					->where('djaci.id_skole','=',Session::get('skola_id'))
					->get(['roditelji.id','djaci.prezime','djaci.ime','roditelji.ime as ime_roditelja','roditelji.prezime as prezime_roditelja'])
					->toArray());

			/*Djaci::join('odeljenje_djak','odeljenje_djak.id_djak','=','djaci.id')
					->join('odeljenja','odeljenja.id','=','odeljenje_djak.id_odeljenje')
					->leftJoin('roditelji','roditelji.id','=','djaci.id_roditelji')
					
					->where('odeljenja.id','=',$id_odeljenja)
					->where('djaci.id_skole','=',Session::get('skola_id'))
					
					->get(['roditelji.id','djaci.prezime','djaci.ime','roditelji.ime as ime_roditelja','roditelji.prezime as prezime_roditelja'])
					->toArray());*/

	}
	public function getObrisiroditelja($id){
			Roditelji::where('id',$id)->delete();
			return Redirect::back()->withErrors('Успешно обрисан родитељ!');
	}
	public function getObrisidjaka($id){
			Djaci::where('id',$id)->delete();
			return Redirect::back()->withErrors('Успешно обрисан ђак!');
	}
}