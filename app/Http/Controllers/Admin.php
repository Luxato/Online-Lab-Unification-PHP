<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Language;

class Admin extends Controller {

	public function index() {
		return view( 'administration/dashboard' );
	}

	public function navigation() {
		$data['navigation'] = $this->navigation;

		return view( 'administration/navigation', $data );
	}

	public function pages() {
		$data['pages'] = DB::table( 'navigation' )->get()->toArray();

		return view( 'administration/pages_list', $data );
	}

	public function page_create() {
		$data['languages'] = Language::select_all();

		return view( 'administration/page_create', $data );
	}

	//TODO create model for this
	public function do_page_create() {
		$name       = $_POST['title'];
		$controller = $_POST['url'];
		$content    = $_POST['slovak'];
		DB::table( 'navigation' )->insert(
			[ 'name' => $name, 'controller' => $controller, 'content' => $content ]
		);
		$data['pages']  = DB::table( 'navigation' )->get()->toArray();
		$data['status'] = 'create-success';

		return view( 'administration/pages_list', $data );
	}

	public function settings() {
		return view( 'administration/settings' );
	}

	public function languages() {
		$data['languages'] = DB::table( 'languages' )->get()->toArray();;

		return view( 'administration/languages', $data );
	}

	public function create_lang() {
		return view( 'administration/create_language' );
	}

}
