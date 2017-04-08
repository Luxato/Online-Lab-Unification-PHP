<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class Contact extends Controller {
	public function index(Request $request, $locale = NULL) {
		// Set up language
		if (empty($locale)) {
			$locale = config('app.fallback_locale');
		}
		app()->setLocale($locale);
		$data['navigation'] = $this->navigation;
		/*$data['section_id'] = $this->section_id;*/


		return view( 'contact', $data );
	}
}
