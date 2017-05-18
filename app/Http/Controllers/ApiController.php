<?php

namespace App\Http\Controllers;

use App\Apikey;
use App\User;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
class ApiController extends Controller {

	public function create_api_key(Request $request) {

	}

	public function index( $apiname, Request $request ) {
		if ( $request->isMethod('get') ) {
			$result = [
				'error' => TRUE,
				'msg'   => 'Method GET not allowed'
			];
			echo json_encode( $result );
			exit;
		}
		switch ( $apiname ) {
			case 'generateApiKey':
				$api = Apikey::where('user_id', decrypt($request->get('secret')))->first();
				$date = new DateTime(null, new DateTimeZone('Europe/London'));
				$new_key = md5(date_timestamp_get($date));
				if(!isset($api)) {
					$api = new Apikey();
					$api->user_id = decrypt($request->get('secret'));
				}
				$api->key = $new_key;
				$api->save();
				$result = [
					'error' => FALSE,
					'key'   => $new_key
				];
				echo json_encode( $result );
				exit;
				break;
		}
	}

}

