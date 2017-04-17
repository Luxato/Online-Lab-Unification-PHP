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
			// TODO flash message on bad login
			echo "autentifikacia sa nepodarila";
		}
	}

	public function login_ldap(Request $request) {
		if(TRUE){
			$adServer = "ldap.stuba.sk";

			$dn  = 'ou=People, DC=stuba, DC=sk';
			$username = $request->get('aislogin');
			$password = $request->get('password');
			$ldaprdn  = "uid=$username, $dn";

			$ldapconn = ldap_connect($adServer);
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

			$bind = ldap_bind($ldapconn, $ldaprdn, $password);
			if ($bind){

				$results=ldap_search($ldapconn,$dn,"uid=$username",array("givenname","sn","mail","cn","uisid","uid"));
				$info=ldap_get_entries($ldapconn,$results);
				$i=0;
				$aisUdaje = array("Meno"=>$info[$i]['givenname'][0],
				                  "Priezvisko"=>$info[$i]['sn'][0],
				                  "Používateľské meno"=>$info[$i]['uid'][0],
				                  "Id"=>$info[$i]['uisid'][0],
				                  "Email"=>$info[$i]['mail'][0]);
				var_dump($aisUdaje);
				//$_SESSION['login'] = $info[$i]['uid'][0];
				//$_SESSION['ldapData'] = $aisUdaje;
				echo "Success";
				$_SESSION['meno']=$info[$i]['givenname'][0];
				//header("Location: succes_log.php");
			} else {
				echo "Chyba pripojenia na server!";
			}
		}
	}

	/**
	 * Logout our user
	 */
	public function logout() {
		Session::flush( 'logged_user_id' );
		Session::flush( 'logged_email' );
		Auth::logout();

		return back();
	}


}