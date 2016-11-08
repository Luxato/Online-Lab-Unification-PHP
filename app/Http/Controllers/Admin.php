<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class Admin extends Controller {

	public function index() {
		return view( 'administration/home' );
	}

	public function navigation() {
		$data['navigation'] = $this->navigation;

		return view( 'administration/navigation', $data );
	}
}
