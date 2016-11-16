<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class Admin extends Controller {

	public function index() {
		return view( 'administration/dashboard');
	}

	public function navigation() {
		$data['navigation'] = $this->navigation;
		return view( 'administration/navigation', $data );
	}

	public function pages() {
		$data['pages'] = DB::table( 'navigation' )->get()->toArray();;
		return view( 'administration/pages_list', $data);
	}

	public function page_create() {

	}
}
