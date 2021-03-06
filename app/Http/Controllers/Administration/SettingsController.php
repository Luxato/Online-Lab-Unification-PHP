<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Language;
use App\Setting;
use App\User;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller {

	public function __construct() {
		$this->middleware( 'auth' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$this->init_navigation( FALSE, TRUE );
		$this->navigation[] = (object) [
			'section_id' => '00',
			'title'      => 'Aktuality'
		];
		$this->navigation[] = (object) [
			'section_id' => '01',
			'title'      => 'Default'
		];

		return view( 'administration/settings', [
			'settings'      => Setting::all(),
			'default_lang'  => $this->default_language,
			'languages'     => \App\Language::all(),
			'pages'         => $this->navigation,
			'default_pages' => (array) json_decode( Setting::all()[1]->setting_value )
		] );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request ) {
		$password_change = FALSE;
		if (strlen($request->get('password')) >= 6) {
			$this->validate($request, [
				'password' => 'required|confirmed|min:5'
			]);
			$user = User::where( [
				'name' => 'Administrator',
				'type' => 'administrator'
			] )->first();
			$user->password = bcrypt($request->get('password'));
			$user->save();
			$password_change = TRUE;
		}
		$settings = Setting::all();

		$default_language                = $settings[0];
		$default_language->setting_value = $request->get( 'language' );
		$default_language->save();

		$landing_pages = [];
		foreach ( $request->get( 'landing_pages' ) as $setting ) {
			$tmp             = explode( '_', $setting );
			$landing_pages[$tmp[0]] = $tmp[1];
		}
		$pages                = $settings[1];
		$pages->setting_value = json_encode( $landing_pages );
		$pages->save();

		if ($password_change) {
			Session::flush( 'logged_user_id' );
			Session::flush( 'logged_email' );
			\Auth::logout();
			Session::flash( 'success', 'successful_logout' );
			redirect('/login');
		}

		\Session::flash( 'success', "Nastavenia boli aktualizované." );

		return back();
	}

}
