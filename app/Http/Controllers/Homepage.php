<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class Homepage extends Controller {
	public function index(Request $request, $locale = NULL) {
		// Set up language
		if (empty($locale)) {
		    $locale = config('app.fallback_locale');
		}
		app()->setLocale($locale);

		$data['navigation'] = $this->navigation;
		return view( 'welcome', $data );
	}
}
