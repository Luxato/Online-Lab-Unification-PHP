<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class Admin extends Controller {

	public function index() {
		return view( 'administration/dashboard');
	}

	public function navigation() {
		$data['navigation'] = $this->navigation;
		return view( 'administration/navigation', $data );
	}

	public function pages() {
		$data['navigation'] = $this->navigation;

		return view( 'administration/new_page', $data);
	}

	public function create_nav_link() {

	}
}
