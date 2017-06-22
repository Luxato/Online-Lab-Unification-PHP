<?php

namespace App\Http\Controllers;

use App\User;
use App\Apikey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Auth;
use DateTime;
use DateTimeZone;
class UserController extends Controller {

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		$this->validate($request, [
			'email' => 'required|email|unique:users',
			'username' => 'required|min:6',
			'password' => 'required|min:6|confirmed'
		]);
		// First check for duplicates.
		$user = User::where( 'email', $request->get('email') )->first();
		if (isset($user)) {
			// We have a duplicate here.
			Session::flash( 'warning', 'duplicated_email' );
		    return back();
		}
		$user        = new User();
		$user->name  = $request['username'];
		$user->email = $request['email'];
		$user->password = Hash::make(trim($request['password']));
		$user->type = 'user';
		$user->save();

		// Create API key
		$date = new DateTime(null, new DateTimeZone('Europe/London'));
		$new_key = md5(date_timestamp_get($date));
		$api = new Apikey();
		$api->user_id = $user->id;
		$api->key = $new_key;
		$api->save();

		Session::set( 'logged_user_id', $user->id );
		Session::set( 'logged_email', $user->email );

		Session::flash( 'success', "account_created" );

		return back();
	}

	public function editProfile(Request $request) {
		if ($request->get('password') !== $request->get('password_confirmation')) {
			Session::flash( 'warning', 'password_do_not_match' );

			return back();
		}
		$this->validate($request, [
			'password' => 'required|min:6|confirmed'
		]);
		$user = User::where('id', decrypt($request->get('secret')))->first();
		$user->password = Hash::make($request->get('password'));
		$user->save();

		Session::flush( 'logged_user_id' );
		Session::flush( 'logged_email' );
		Auth::logout();
		Session::flash( 'success', 'successful_password_change' );

		return back();
	}
}
