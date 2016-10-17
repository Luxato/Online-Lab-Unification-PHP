<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;

class Homepage extends Controller {
	public function index() {
		$text = 'toto je vypis z controllera Intro';
		$data = DB::table('navigation')->get();
		$data['navigation'] = $data->toArray();
		/*echo '<pre>';
		print_r( $data );
		echo '</pre>';*/
		return view( 'welcome', $data );
	}
}
