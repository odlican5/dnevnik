<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Korisnici;
use App\Predmeti;
use App\Nastavnici;
use App\Odeljenja;
use App\Raspored;
use App\NastavniciOdeljenja;
use Illuminate\Http\Request;
use App\Security;
use Illuminate\Support\Facades\Session;
use DB;
use App\Obavestenja;
use File;

class NastavniciadminKontroler extends Controller {

	public function postUcitajnastpood(){
		return json_encode(
			NastavniciOdeljenja::join('odeljenja','odeljenja.id','=','nastavnici_odeljenja.odeljenja_id')
			->join('nastavnici','nastavnici.id','=','nastavnici_odeljenja.nastavnici_id')
			->where('nastavnici.skole_id','=',Session::get('skola_id'))
			->get(['nastavnici_odeljenja.id','odeljenja.razred','odeljenja.odeljenje',DB::raw("CONCAT(nastavnici.ime, ' ', nastavnici.prezime, '') as ime_prezime")])->toArray()
			);
	}
	public function postObavestenje(){
			// getting all of the post data
	if(File::exists(Input::file('image'))){
		 $file = array('image' => Input::file('image'));
			  // setting up rules
			  $rules = array('image' => 'mimes:jpeg,jpg,png,gif|max:5000',); //mimes:jpeg,bmp,png and for max size max:10000
			  // doing the validation, passing post data, rules and the messages
			  $validator = Validator::make($file, $rules);
			  if ($validator->fails()) {
			    // send back to the page with the input data and errors
			    return Redirect::back()->withInput()->withErrors($validator);
			  }
			  else {
			    // checking file is valid.
			    if (Input::file('image')->isValid()) {
			    	$obav=new Obavestenja();
			    	$obav->obavestenje=Input::get('obavestenje');
			      $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
			      $fileName = rand(11111,99999).'.'.$extension; // renameing image
			      $destinationPath = '/'.Session::get('skola').'/'.$fileName; // upload path
			      $obav->id_skole=Session::get('skola_id');
			    	$obav->url=$destinationPath;
			    	$obav->save();
			    	$dest=public_path().'/img_skole/'.Session::get('skola');
			    	//next line uncoment to display on server
			    	//$dest='/home/itservic/public_html/odlican5/img_skole/'.Session::get('skola');
			      Input::file('image')->move($dest, $fileName); // uploading file to given path
			      // sending back with message
			      Session::flash('success', 'Успешно!'); 
			      return Redirect::back();
			    }
			    else {
			      // sending back with error message.
			      Session::flash('error', 'Фајл није валидан!');
			      return Redirect::back();
			    }
			  }
	}elseif(Input::get('update_flag')!=null){
		$id=Input::get('update_flag');
		Obavestenja::where('id','=',$id)->update(['obavestenje'=>Input::get('obavestenje')]);
		/*$obav=new Obavestenja();
		$obav->obavestenje=Input::get('obavestenje');
		$obav->id_skole=Session::get('skola_id');
		$obav->save();*/
		Session::flash('success', 'Успешно ажурирање!'); 
			      return Redirect::back();
	}else{
		Session::flash('success', 'Izaberite sliku!'); 
			      return Redirect::back();
	}
	 
}
	public function postUcitajobavestenja(){
		return json_encode(Obavestenja::where('id_skole','=',Session::get('skola_id'))
			  	->orderBy('created_at','DESC')
			  	->get(['id','obavestenje','url','created_at','naslov'])->toArray());
	}
	public function postUcitaj(){
		$nastavnici=Nastavnici::lists('ime','id');
				return json_encode(["korisnici"=>
					Predmeti::leftjoin('skole','skole.id','=','predmeti.skole_id')
					->leftjoin('nastavnici','nastavnici.predmeti_id','=','predmeti.id')
					->where('skole.id','=',Session::get('skola_id'))
					->get(['predmeti.id','predmeti.naziv as predmeti','skole.naziv as skole','nastavnici.ime','nastavnici.prezime'])
					->toArray(),"nastavnici"=>$nastavnici]);
	}
	public function postNovipredmet(){	
		$predmet=new Predmeti();
		$predmet->naziv=Input::get('predmet');
		$predmet->skole_id=Session::get('skola_id');
		$predmet->save();
		return Redirect::back()->withErrors('Успешно сачувано!');
	}
	public function postNovinastavnik(){//novi nastavnik i ažuriranje nastavnika 
		if($_POST['update_nastavnik']==false){


			$nastavnik=new Nastavnici();
			$nastavnik->ime=Input::get('nastavnik_ime');
			$nastavnik->prezime=Input::get('nastavnik_prezime');
			//$nastavnik->maticni_broj=Input::get('korisnicko_ime');
			//$usn=strtolower(Input::get('nastavnik_prezime')).strtolower(substr(Input::get('nastavnik_ime'), 0, 1));

			$nastavnik->username=Input::get('korisnicko_ime');
			$nastavnik->password=Security::generateHashPass(Input::get('korisnicko_ime'));
			$nastavnik->prava_pristupa_id=3;

			$nastavnik->predmeti_id=Input::get('predmeti');
			$nastavnik->skole_id=Session::get('skola_id');
			$nastavnik->aktivan=1;
			$nastavnik->save();
			return Redirect::back()->withErrors('Успешно сачувано!');
		}else
		{
			Nastavnici::where('id',$_POST['nastavnik_id'])->update(['ime'=>$_POST['nastavnik_ime'],'username'=>$_POST['korisnicko_ime'],'password'=>Security::generateHashPass($_POST['korisnicko_ime']),'prezime'=>$_POST['nastavnik_prezime'],'predmeti_id'=>$_POST['predmeti']]);
			return Redirect::back()->withErrors('Успешно ажурирано!');
		}
		
	}
	public function postEditobavestenja(){
		return json_encode(Obavestenja::where('id','=',$_POST['id'])->get(['obavestenje'])->toArray());
	}
	public function getObrisipredmet($id){
			
			Predmeti::where('id',$id)->delete();
			return Redirect::back()->withErrors('Успешно обрисан предмет!');;
	}
	public function getObrisiobavestenje($id){
			
			Obavestenja::where('id',$id)->delete();
			return Redirect::back()->withErrors('Успешно обрисанo oбавештење!');
	}
	public function getObrisinastavnika($id){
			
			Nastavnici::where('id',$id)->delete();
			return Redirect::back()->withErrors('Успешно обрисан наставник!');
	}
	public function getObrisirazredodeljenje($id){
			NastavniciOdeljenja::where('odeljenja_id','=',$id)->delete();
			Raspored::where('odeljenje_id',$id)->delete();
			Odeljenja::where('id',$id)->delete();
			return Redirect::back()->withErrors('Успешно обрисаno одељење и разредни!');
	}
	public function getObrisinastavnikepood($id){
			NastavniciOdeljenja::where('id',$id)->delete();
			return Redirect::back()->withErrors('Успешно обрисан наставник!');
	}
	public function postUcitajnastavnike(){
		return json_encode(Nastavnici::join('predmeti','predmeti.id','=','nastavnici.predmeti_id')
			->where('nastavnici.skole_id','=',Session::get('skola_id'))
			->get(['nastavnici.id','nastavnici.ime','nastavnici.prezime','nastavnici.username','predmeti.id as predmet_id','predmeti.naziv as naziv_predmeta'])->toArray());
	}
	public function postUcitajrazredne(){
		return json_encode(Odeljenja::join('nastavnici','nastavnici.id','=','odeljenja.nastavnici_id')
			->where('nastavnici.skole_id','=',Session::get('skola_id'))
			->orderBy('razred','asc')->orderBy('odeljenje','asc')
			->get(['odeljenja.id','nastavnici.id as id_nast','odeljenja.razred','odeljenja.odeljenje','nastavnici.ime'])->toArray());
	}
	public function postIzmeniubazipredmet(){
			Predmeti::where('id','=',$_POST['id'])->update(['naziv'=>$_POST['name']]);
			return $_POST['id'];
	}
	public function postIzmeniubazinastavnika(){
			Nastavnici::where('id','=',$_POST['id'])->update(['ime'=>$_POST['name']]);
			return $_POST['id'];
	}
	public function postDodajRazrednog(){//dodavanje odeljenja i razrednog staresine
		if($_POST['update_id']==false){
			$data=Input::all();
			$rules = [
	        'razred'	=> 'Required|numeric',
	        'odeljenje'=>'Required|numeric',
			];
			$messages = [
	        'razred.required' => 'Унесите разред',
	        'odeljenje.required' => 'Унесите одељење',
	        'razred.numeric' => 'Разред мора бити број',
	        'odeljenje.numeric' => 'Одељење мора бити број',
	        ];
			$v=Validator::make($data,$rules,$messages);
			if($v->fails())
			{
				return Redirect::back()->withErrors($v->errors());
			}

			$razredi=$_POST['razred'];
			$odeljenjei=$_POST['odeljenje'];
			$razredni=$_POST['razredni'];	
			//$odeljenje=new odeljenja();

			$od=Odeljenja::firstOrNew(['razred' =>$razredi,'odeljenje'=>$odeljenjei,'nastavnici_id' =>$razredni]);
				
			if (!$od->id) 
			{
				$od->save();
				return Redirect::back()->withErrors(['Успешно унето!']);
			} else 
			{
				return Redirect::back()->withErrors(['Комбинација ОДЕЉЕЊЕ-РАЗРЕД већ постоји!']);		  
			}

		}else
		{
			Odeljenja::where('id',$_POST['odeljenje_id'])->update(['razred'=>$_POST['razred'],'odeljenje'=>$_POST['odeljenje'],'nastavnici_id'=>$_POST['razredni']]);
			return Redirect::back()->withErrors(['Успешно ажурирано!']);
		}
	}
	public function postNastavnicipoodeljenjima(){
		
		$odeljenja_idi=$_POST['razredi'];//ovo je odeljenja_id
		$nastavnici_po_odeljenjima=$_POST['nastavnici_po_odeljenjima'];
		foreach ($nastavnici_po_odeljenjima as $key=>$val) {
			$odeljenje=new NastavniciOdeljenja();
			$odeljenje->odeljenja_id=$odeljenja_idi;
			$odeljenje->nastavnici_id=$val;
			$odeljenje->save();
		}
		return Redirect::back()->withErrors('Успешно сачувано!');
	}


	public function postEditUcitaj(){
		return json_encode(Predmeti::find($_POST['id']));
	}
	public function postDeaktiviraj(){
		$aktivan=$_POST['aktivan']?0:1;
		Korisnici::find($_POST['id'],['id','aktivan'])->update(['aktivan'=>$aktivan]);
		return $aktivan;
	}
	public function postAzuriraj(){
		$podaci=json_decode(Input::get('podaci'));
		//UNOS PODATAKA U BAZU

		$predmet=isset($podaci->id)? Predmeti::find($podaci->id) : new Predmeti();
		$predmet->naziv = $podaci->naziv;
		$predmet->save();

		/*if(Session::has('aplikacija')){
			KorisniciAplikacije::insert([
				[
					'korisnici_id'=>$korisnik->id,
					'aplikacija_id'=>Aplikacija::where('slug',Session::get('aplikacija'))->get(['id'])->first()->id
				]
			]);
		}*/
		return json_encode(['msg'=>'Uspešan unos.','check'=>1]);
	}
	public function postIndex(){
		$podaci=json_decode(Input::get('podaci'));
		 $validator=Validator::make([
            'username'=>$podaci->username,
            'email'=>$podaci->email,
            'password'=>$podaci->password,
        ],[
            'username'=>'required|min:4|unique:korisnici,username',
            'email'=>'required|email|unique:korisnici,email',
            'password'=>'required|min:4',

        ],[
            //username
            'username.required'=>'Obavezan unos username-a.',
            'username.min'=>'Minimalna duzina username-a je :min.',
            'username.unique'=>'Navedeni username je u upotrebi.',
            //email
            'email.email'=>'Pogrešno unesen email.',
            'email.required'=>'Obavezan unos email-a.',
            'email.unique'=>'Navedeni email je u upotrebi.',
            //pass
            'password.required'=>'Obavezan unos password-a.',
            'password.min'=>'Minimalna duzina password-a je :min.',
        ]);
		if($validator->fails()){
			$msg='<p>Dogodila se greška: <br><ol>';
			foreach($validator->errors()->toArray() as $greske)
				foreach($greske as $greska)
					$msg.='<li>'.$greska.'</li>';
			$msg.='</ol>';
			return json_encode(['msg'=>$msg,'check'=>0]);
		}

		$novi = new Korisnici();
		$novi->prezime=$podaci->prezime;
		$novi->ime=$podaci->ime;
		$novi->username=$podaci->username;
		$novi->password=Security::generateHashPass($podaci->password);
		$novi->email=$podaci->email;
		$novi->prava_pristupa_id=$podaci->prava_pristupa_id;
		$novi->vrsta_korisnika_id=$podaci->vrsta_korisnika_id;
		$novi->naziv=$podaci->naziv;
		$novi->adresa=$podaci->adresa;
		$novi->grad=$podaci->grad;
		$novi->jib=$podaci->jib;
		$novi->pib=$podaci->pib;
		$novi->pdv=$podaci->pdv;
		$novi->ziro_racun_1=$podaci->ziro_racun_1;
		$novi->ziro_racun_2=$podaci->ziro_racun_2;
		$novi->banka_1=$podaci->banka_1;
		$novi->banka_2=$podaci->banka_2;
		$novi->registracija=$podaci->registracija;
		$novi->broj_upisa=$podaci->broj_upisa;
		$novi->telefon=$podaci->telefon;
		$novi->opis=$podaci->opis;
		$novi->save();
		return json_encode(['msg'=>'Uspešno ste dodali novog korisnika.','check'=>1]);
	}
	public function postUploadFoto(){
		/*if(!Security::autentifikacijaTest(2,'min')){
			echo json_encode(['error'=>'Niste prijavljeni na platformu.']);
			return;
		}*/
		if (empty($_FILES['foto'])) {
			echo json_encode(['error'=>'Nisu pronađeni fajlovi za upload.']);
			return;
		}
		$folder = 'img/'.(Session::has('aplikacija')?'aplikacije/'.Session::get('aplikacija').'/':'').'korisnici/'.((isset($_POST['id'])and($_POST['id']!='undefined'))?$_POST['id']:(Korisnici::max('id')+1)).'.'.explode('.', $_FILES['foto']['name'])[1];
		$success = null;
		$paths=null;
		if(file_exists($folder)) unlink($folder);
		if(move_uploaded_file($_FILES['foto']['tmp_name'], $folder)){
			$success = true;
			$paths = $folder.$_FILES['foto']['name'];
		} else {
			$success = false;
		}
		if ($success === true) {
			$output = $folder;
		} elseif ($success === false) {
			$output = ['error'=>'Greška prilikom upload-a. Kontaktirajte tehničku podršku platforme.'];
			unlink($paths);
		} else {
			$output = ['error'=>'Fajlovi nisu procesuirani.'];
		}
		echo json_encode($output);
		return;
	}
	public function postUcitajKorisnike(){
		Session::put('faktura.vrsta_korisnika',(int)$_POST['vrsta_korisnika']);
		return json_encode(Korisnici::join('korisnici_aplikacije as ka','ka.korisnici_id','=','korisnici.id')
			->join('aplikacija as a','a.id','=','ka.aplikacija_id')
			->where('a.slug',Session::get('aplikacija'))
			->where('korisnici.prava_pristupa_id',$_POST['vrsta_korisnika'])
			->where(function($query){
				$query->where('korisnici.prezime','Like','%'.$_POST['pretraga'].'%')
					->orWhere('korisnici.ime','Like','%'.$_POST['pretraga'].'%')
					->orWhere('korisnici.naziv','Like','%'.$_POST['pretraga'].'%')
					->orWhere('korisnici.jmbg','Like','%'.$_POST['pretraga'].'%');
			})
			->get(['korisnici.id','korisnici.prezime','korisnici.ime','korisnici.jmbg',
				'korisnici.naziv','korisnici.adresa','korisnici.grad','korisnici.telefon'])
			->toArray());
	}
	public function postIzaberiKorisnika(){
		$korisnik=Korisnici::find($_POST['id'],['korisnici.id','korisnici.prezime','korisnici.ime',
			'korisnici.naziv','korisnici.adresa','korisnici.grad','korisnici.jib','korisnici.pib','korisnici.pdv',
			'korisnici.ziro_racun_1','korisnici.banka_1','korisnici.ziro_racun_2','korisnici.banka_2',
			'korisnici.registracija','korisnici.broj_upisa','korisnici.telefon','korisnici.jmbg','korisnici.broj_licne_karte'])
			->toArray();
		if(Session::has('faktura.korisnik')) Session::forget('faktura.korisnik');
		Session::put('faktura.korisnik',$korisnik);
		Session::put('faktura.korisnik.ka_id',KorisniciAplikacije::where('aplikacija_id',Session::get('aplikacija_id'))
			->where('korisnici_id',$korisnik['id'])->get(['id'])->first()->id);
		return json_encode($korisnik);
	}
}
