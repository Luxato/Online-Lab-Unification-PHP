<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class Homepage extends Controller {


	/*public function index(Request $request, $locale = NULL) {
		// Set up language
		if (empty($locale)) {
		    $locale = config('app.fallback_locale');
		}
		app()->setLocale($locale);
		$data['navigation'] = $this->navigation;
		$data['section_id'] = $this->section_id;

		return view( 'welcome', $data );
	}*/

	public function index( Request $request, $slug = NULL ) {
		$data['navigation'] = $this->navigation;
		$data['section_id'] = $this->section_id;
		$page               = DB::table( 'navigation' )->where( 'controller', $slug )->get()->toArray();
		if ( isset( $page[0]->content_file ) ) {
			$data['content_file'] = $page[0]->content_file;
		}
		if ( isset( $page[0]->name ) ) {
			$data['name'] = $page[0]->name;
		} else {
			$data['name'] = 'unknown';
		}

		return view( 'welcome', $data );
	}
}
