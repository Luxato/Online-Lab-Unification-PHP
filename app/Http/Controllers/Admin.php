<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Language;
use App\Translation;


class Admin extends Controller {

	public function index() {
		return view( 'administration/dashboard' );
	}

	public function navigation() {
		$this->init_navigation();
		$data['navigation'] = $this->navigation;

		return view( 'administration/navigation', $data );
	}

	public function languages() {
		$data['languages'] = Language::all();

		return view( 'administration/languages', $data );
	}

	public function create_lang() {
		return view( 'administration/create_language', [
			'translations' => Translation::all()->toArray()
		]);
	}

}
