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

		$data = DB::table('navigation')->get();
		$data['navigation'] = $data->toArray();
		return view( 'welcome', $data );
	}
}
