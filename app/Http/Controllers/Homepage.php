<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Page;

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
		$pages = Page::with( 'feature' )->get()->toArray();
		echo '<pre>';
		print_r( $pages );
		echo '</pre>';

		$data['navigation'] = $this->navigation;
		$data['section_id'] = $this->section_id;
		if ( ! isset( $slug ) ) {
			$blade = 'default';
		} else {
			$page  = DB::table( 'navigation' )->where( 'controller', $slug )->get()->toArray();
			$blade = 'user_created_pages/' . $page[0]->controller;
		}
		if ( isset( $page[0]->content_file ) ) {
			$data['content_file'] = $page[0]->content_file;
		}
		if ( isset( $page[0]->name ) ) {
			$data['name'] = $page[0]->name;
		} else {
			$data['name'] = 'unknown';
		}

		return view( $blade, $data );
	}
}
