<?php

namespace App\Http\Controllers;

use App\Apikey;
use Illuminate\Http\Request;
use Mail;

class ApiController extends Controller {

	public function index( $apiname, Request $request ) {
		Mail::send(['text'=>'email/mail'],['name', 'Tester Testovic'], function ($message) {
			$message->to('lukas@stranovsky.sk')->subject('Test Email');
			$message->from('robot@stranovsky.sk', 'Robot');
		});
		/*if ( Request::isMethod('get') ) {
			$result = [
				'error' => TRUE,
				'msg'   => 'Method GET not allowed'
			];
			echo json_encode( $result );
			exit;
		}*/
		switch ( $apiname ) {
			case 'form2mail':
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
				// TODO log what happened
				break;
		}
	}

}
