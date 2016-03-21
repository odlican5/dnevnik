<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Korisnici;
use App\Skole;
use App\PravaPristupa;
use App\VrstaKorisnika;
use Illuminate\Http\Request;
use App\Security;
use Illuminate\Support\Facades\Session;
use File;
use DirectoryIterator;

class SkoleKontroler extends Controller {
	public function getIndex(){

		return Security::autentifikacija('super-admin.skole.index',null,5);
		
	}
	public function postUcitaj(){//učitava sve pri ucitavanju stranice, i oziva se pri pretrazi	
		return json_encode(Skole::where(function($query){
				$query->where('skole.naziv','Like','%'.(isset($_POST['pretraga'])?$_POST['pretraga']:'').'%')
					->orWhere('skole.slug','Like','%'.(isset($_POST['pretraga'])?$_POST['pretraga']:'').'%')
					->orWhere('skole.direktor','Like','%'.(isset($_POST['pretraga'])?$_POST['pretraga']:'').'%')
					->orWhere('skole.adresa','Like','%'.(isset($_POST['pretraga'])?$_POST['pretraga']:'').'%')
					->orWhere('skole.telefon','Like','%'.(isset($_POST['pretraga'])?$_POST['pretraga']:'').'%')
					->orWhere('skole.email','Like','%'.(isset($_POST['pretraga'])?$_POST['pretraga']:'').'%')
					->orWhere('skole.sediste','Like','%'.(isset($_POST['pretraga'])?$_POST['pretraga']:'').'%');
				})
				->get(['skole.id','skole.naziv','skole.slug','skole.adresa','skole.sediste','skole.direktor','skole.aktivan','skole.telefon','skole.email'])
				->toArray());
	}
	public function postDeaktiviraj(){
		$aktivan=$_POST['aktivan']?0:1;
		Skole::find($_POST['id'],['id','aktivan'])->update(['aktivan'=>$aktivan]);
		return $aktivan;
	}
	public static function rmove($src, $dest){
        if(!is_dir($src)) return false;
        if(!is_dir($dest))
            if(!mkdir($dest)) return false;
        $i = new DirectoryIterator($src);
        foreach($i as $f) {
            if($f->isFile()) {
                rename($f->getRealPath(), "$dest/" . $f->getFilename());
            } else if(!$f->isDot() && $f->isDir()) {
                rmove($f->getRealPath(), "$dest/$f");
                
            }
        }rmdir($src);
       // unlink($src);
    }
	public function postAzuriraj(){
		$podaci=json_decode(Input::get('podaci'));

		//kreiranje foldera za dodavanje slika
		if (isset($podaci->id)) {
			$path=public_path().'/img_skole/'	.$podaci->slug;
			File::makeDirectory($path,$mode=0777,true,true);
			$slug=Skole::where('id','=',$podaci->id)->get(['skole.slug'])->toArray();
			$src=public_path().'/img_skole/'.$slug[0]['slug'];
			SkoleKontroler::rmove($src, $path=public_path().'/img_skole/'.$podaci->slug);
			$skola=isset($podaci->id)? Skole::find($podaci->id) : new Skole();
			
			$skola->naziv = $podaci->naziv;
			$skola->slug = $podaci->slug;
			$skola->sediste = $podaci->sediste;
			$skola->direktor = $podaci->direktor;
			$skola->adresa = $podaci->adresa;
			$skola->telefon = $podaci->telefon;
			$skola->email = $podaci->email;
			$skola->korisnici_id = 3;//korisnici id proveriti
			$skola->save();
		
		}else{
			$path=public_path().'/img_skole/'	.$podaci->slug;
			File::makeDirectory($path,$mode=0777,true,true);
			$skola=new Skole();
			$skola->naziv = $podaci->naziv;
			$skola->slug = $podaci->slug;
			$skola->sediste = $podaci->sediste;
			$skola->direktor = $podaci->direktor;
			$skola->adresa = $podaci->adresa;
			$skola->telefon = $podaci->telefon;
			$skola->email = $podaci->email;
			$skola->korisnici_id = 3;//korisnici id proveriti
			$skola->save();
		}

		return json_encode(['msg'=>'Uspešan unos.','check'=>1]);
	}
	public function postEditUcitaj(){
		return json_encode(Skole::find($_POST['id']));
	}

}