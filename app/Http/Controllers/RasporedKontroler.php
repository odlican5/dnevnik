<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
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
use App\Raspored;
use App\OdeljenjeDjak;
use App\Dogadjaji;
use Illuminate\Support\Facades\DB;
use App\Izostanci;
use App\Poruke;
use DateTime;
use Barryvdh\Debugbar\Facade;
use DebugBar\StandardDebugBar;
use App\Http\Controllers\App;
use PDF;
class RasporedKontroler extends Controller {
	public function getIndex(){
		$rasporedi=Raspored::where('skole_id',Session::get('skola_id'))
		->where('odeljenje_id','=',Odeljenja::where('nastavnici_id','=',Session::get('id'))->pluck('id'))
		->get(['id','predmet','broj_casa','dan','boja','boja_teksta'])->toArray();		
		$dani=['Понедељак','Уторак','Среда','Четвртак','Петак','Субота','Недеља'];
		return Security::autentifikacija('profesor-admin.raspored',compact('rasporedi','dani'),3);
	}
	public function getOdeljenja(){//распоред за родитеље

		$od=Roditelji::join('djaci','djaci.id_roditelji','=','roditelji.id')
			->join('odeljenje_djak','odeljenje_djak.id_djak','=','djaci.id')
			->join('odeljenja','odeljenja.id','=','odeljenje_djak.id_odeljenje')
			->where('roditelji.id',Session::get('id'))
			->get(['odeljenja.id'])->toArray();
	
		$rasporedi=Raspored::where('odeljenje_id', '=', $od[0]['id'])
		->get(['id','predmet','broj_casa','dan','boja','boja_teksta'])->toArray();
		//dd($rasporedi);		
		$dani=['Понедељак','Уторак','Среда','Четвртак','Петак','Субота','Недеља'];
		return Security::autentifikacija('roditelj.raspored',compact('rasporedi','dani'),2);
	} 

	public function postUnosRasporeda(){
		if(!Input::get('predmet')){return Redirect::back()->withError('Niste uneli predmet!');}
		$od=Odeljenja::where('nastavnici_id','=',Session::get('id'))->pluck('id');
		$raspored=new Raspored();
		$raspored->skole_id=Session::get('skola_id');
		$raspored->predmet=Input::get('predmet');
		$raspored->broj_casa=Input::get('broj_casa');
		$raspored->dan=Input::get('dan');
		$raspored->boja=Input::get('boja');
        $raspored->boja_teksta=Input::get('boja_teksta');
        $raspored->odeljenje_id=$od;
		$raspored->save();
		return Redirect::back();
	}
	public function postIzmeni(){
		$podaci=json_decode(Input::get('podaci'));
		if(!$podaci->predmet1){return json_encode(['msg'=>'Unesite predmet.','check'=>0]);}
		$id=$podaci->id;
		$predmet=$podaci->predmet1;
		$boja=$podaci->textboja;
		$boja_teksta=$podaci->textbojateksta;
		Raspored::where('id',$id)->update(['predmet'=>$predmet,'boja'=>$boja,'boja_teksta'=>$boja_teksta]);
		return json_encode(['msg'=>'Uspešno ste ažurirali predmet. Osvežite stranu!!!','check'=>1]);
	}
	public function postObrisi(){
		$podaci=json_decode(Input::get('podaci'));
		$id=$podaci->id;
		Raspored::where('id',$id)->delete();
		return json_encode(['msg'=>'Uspešno ste obrisali predmet.','check'=>1]);
	}

	public function getPdf(){
		$pdf = PDF::loadView('pdf.svedocanstvo15a')->setWarnings(false);
        return $pdf->stream("dompdf_out.pdf");


		

	/*$data=['asdf'=>'sasa'];
	$pdf = PDF::loadView('pdf.invoice', compact('data'));
	return $pdf->download('invoice.pdf');
*/
		//$html='<h1>Test</h1>';
//PDF::loadHTML($html)->setPaper('a4')->setOrientation('landscape')->setWarnings(false)->save('myfile.pdf');

	}
	
	
	
	
}