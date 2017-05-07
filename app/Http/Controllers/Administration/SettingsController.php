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

		return view( 'administration/settings', [
			'settings' => Setting::all(),
			'default_lang' => $this->default_language,
			'languages' => \App\Language::all()
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request) {
		$default_language = Setting::all()[1];
		$default_language->setting_value = $request->get('language');
		$default_language->save();

		\Session::flash( 'success', "Nastavenia boli aktualizované." );

		return back();
	}

}
