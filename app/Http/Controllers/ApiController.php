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
			case 'form2mail':/*
				// Verify and TODO validate required inputs
				$required = [ 'apikey', 'from', 'to', 'subject', 'redirectOk', 'redirectFalse' ];
				foreach ( $required as $input ) {
					if ( ! $request->has( $input ) ) {
						$result = [
							'error' => TRUE,
							'msg'   => 'Missing required field ' . $input
						];
						//echo json_encode( $result );
						//exit;
					}

				}
				// Verify token
				if ( $key_user = Apikey::where( 'key', 'acjkasnckjasbcakjsbcajskb' )->with( 'user' )->get()->first() ) {
					// Key exists let's send email
					echo $key_user->toJson();



					$result = [
						'error' => FALSE,
						'msg'   => 'Message has been sent'
					];
					echo json_encode( $result );
					exit;
				} else {
					// Key does not exist
					$result = [
						'error' => TRUE,
						'msg'   => 'API key does not exists'
					];
					echo json_encode( $result );
					exit;
				}
				// TODO log what happened*/
				break;
		}
	}

}

