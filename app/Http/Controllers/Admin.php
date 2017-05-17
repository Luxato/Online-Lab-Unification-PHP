<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Language;
use App\Translation;


class Admin extends Controller {

	public function __construct() {
		$this->middleware( 'auth' );
	}

	public function index() {
		return view( 'administration/dashboard' );
	}

	public function create_lang() {
		return view( 'administration/create_language', [
			'translations' => Translation::all()->toArray()
		]);
	}

}
