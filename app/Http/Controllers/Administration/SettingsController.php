<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Http\Middleware\Language;
use App\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller {
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

		\Session::flash( 'success', "Nastavenia boli aktualizované." );

		return back();
	}

}
