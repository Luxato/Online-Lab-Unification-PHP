<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {

	public function login( Request $request ) {
		if ( Auth::attempt( [
			'email'    => $request->email,
			'password' => $request->password
		] )
		) {
			$user = User::where( 'email', $request->email )->first();
			if ( $user->is_user() ) { // We don't want admins here..
				// We have user, lets create session
				Session::set( 'logged_user_id', $user->id );
				Session::set( 'logged_email', $user->email );

				return redirect('/');
			}
		} else {
			// Authentificaiton failed
			echo "autentifikacia sa nepodarila";
		}
	}

	/**
	 * Logout our user
	 */
	public function logout() {
		Session::flush('logged_user_id');
		Session::flush('logged_email');
		Auth::logout();

		return back();
	}


}