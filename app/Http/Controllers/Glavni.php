<?php namespace App\Http\Controllers;

use App\OsnovneMetode;

class Glavni extends Controller {

	public function getIndex()
	{
		return view('index');
	}
}
