<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class Mockup extends Controller {
	public function index(Request $request, $locale = NULL) {
		$data['navigation'] = $this->navigation;
		$data['section_id'] = $this->section_id;
		return view( 'mockup1', $data );
	}
}
