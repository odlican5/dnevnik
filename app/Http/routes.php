<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|Route::get('/', function () {
    return view('welcome');
});
*/
/*Route::get('/sendmail',function(){
	Mail::later(5, 'emails.queued_email', ['name'=>'sasa jovic'], function($message){
		$message->to('jovicsasajovic@gmail.com','sasa jovic')->subject('welcome');
	});
	return 'sending mail';
});*/

/*Route::get('/send', function () {
    $exitCode = Artisan::call('mail:send');
});*/




Route::get('dbmigrate', 'DbmigrateController@index');
Route::get('/proba/pdf', 'PdfController@invoice');
Route::controller('/administracija/raspored','RasporedKontroler');
Route::controller('/administracija/roditelj','RoditeljiKontroler');
Route::controller('/administracija/poruke','PorukeKontroler');
Route::controller('/administracija/izostanci','IzostanciKontroler');
Route::controller('/administracija/dogadjaji','DogadjajiKontroler');
Route::controller('/administracija/ocene','OceneKontroler');
Route::controller('/administracija/unos-djaka','UnosdjakaKontroler');
Route::controller('/administracija/nastavniciadmin','NastavniciadminKontroler');
Route::controller('/administracija/predmeti','PredmetiKontroler');
Route::controller('/administracija/skole','SkoleKontroler');
Route::controller('/administracija/korisnici','KorisniciKontroler');
Route::controller('/administracija/profil','ProfilKontroler');
Route::controller('/administracija','Administracija');
Route::controller('/','Glavni');

