<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Language;

class Worker extends Controller {
	// TODO do not use $_POST variable, backend validation
	public function do_create_language() {
		$title    = $_POST['title'];
		$shortcut = $_POST['shortcut'];
		Language::_create( $title, $shortcut );

		$data['status']    = 'create-success';
		$data['languages'] = Language::select_all();

		return view( 'administration/languages', $data );
	}

	public function do_delete_language() {
		$language_id = $_POST['languageID'];
		$language    = Language::find( $language_id );
		if ( $language->delete() ) {
			$data['status'] = 'delete-success';
		}
		$data['languages'] = Language::select_all();

		return view( 'administration/languages', $data );
	}
}
