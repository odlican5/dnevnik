<?php namespace App\Http\Controllers;


use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Korisnici;
use App\Predmeti;
use App\Dogadjaji;
use DateTime;
use App\PravaPristupa;
use Illuminate\Http\Request;
use App\Security;
use Illuminate\Support\Facades\Session;

class DogadjajiKontroler extends Controller {
	public function getIndex(){
		$collection =Dogadjaji::get();
		$podaci=$collection->groupBy('datum');
		$podaci->toArray();
		//$dogadjaji['datum']=Dogadjaji::get(['datum'])->toArray();
		dd($podaci->toArray());
		/*$podaci['kalendar']='';
		foreach($dogadjaji as $dogadjaj) 
		{
			$podaci['kalendar'].='"'.$dogadjaj['datum'].'" : {"number" : 2,"badgeClass" : "badge-success", "dayEvents" : [{"title" : "'.$dogadjaj['dogadjaj'].'","status" : "'.$dogadjaj['status'].'","time" : "10:30PM"}]},';
		}*/

		//dd($podaci['kalendar']);
	
	return Security::autentifikacija('profesor-admin.dogadjaji',compact('podaci'),3);
	}

	public function postUnesiDogadjaj(){			
		$podaci=json_decode(Input::get('podaci'));		
		$dog=new Dogadjaji();
		$datum = new DateTime($podaci->datum);
		$dog->datum=date_format($datum,"Y-m-d");
		$dog->dogadjaj=$podaci->dogadjaj;
		$dog->save();
		return json_encode(['msg'=>'Успешно сте унели догадјај.','check'=>1]);	
	}

}
