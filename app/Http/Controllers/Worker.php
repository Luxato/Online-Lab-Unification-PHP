<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Language;

class Worker extends Controller {
	public function do_create_language() {
		$title    = $_POST['title'];
		$shortcut = $_POST['shortcut'];
		Language::_create( $title, $shortcut );

	    return view( 'administration/create_language' );
    }
}
