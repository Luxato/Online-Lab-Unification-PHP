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
		], false, false )
		) {
			$user = User::where( 'email', $request->email )->first();
			if ( $user->is_user() ) { // We don't want admins here..
				// We have user, lets create session
				Session::set( 'logged_user_id', $user->id );
				Session::set( 'logged_email', $user->email );
				isset($user->apikey->key) ? Session::set( 'apikey', $user->apikey->key ) : Session::set( 'apikey', FALSE ) ;

				return redirect( '/' );
			}
		} else {
			// Authentificaiton failed
			Session::flash( 'warning', 'wrong_details' );

			return back();
		}
	}

	public function login_ldap(Request $request) {
		$adServer = "ldap.stuba.sk";
		$dn  = 'ou=People, DC=stuba, DC=sk';
		$username = $request->get('aislogin');
		$password = $request->get('password');
		$ldaprdn  = "uid=$username, $dn";

		$ldapconn = ldap_connect($adServer);
		ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

		$bind = @ldap_bind($ldapconn, $ldaprdn, $password);
		if ($bind){
			$results=ldap_search($ldapconn,$dn,"uid=$username",array("givenname","sn","mail","cn","uisid","uid"));
			$info=ldap_get_entries($ldapconn,$results);
			$user = User::firstOrNew(['name' => $info[0]['uid'][0], 'type' => 'ldap']);
			$user->name = $info[0]['uid'][0];
			$user->email = $info[0]['mail'][0];
			$user->type = 'ldap';
			$user->save();
			Session::set( 'logged_user_id', $user->id );
			Session::set( 'logged_email', $user->email );
			return back();
		} else {
			Session::flash( 'warning', 'wrong_details' );
			return back();
		}
	}

	/**
	 * Logout our user
	 */
	public function logout() {
		Session::flush( 'logged_user_id' );
		Session::flush( 'logged_email' );
		Auth::logout();
		Session::flash( 'success', 'successful_logout' );

		return back();
	}


}