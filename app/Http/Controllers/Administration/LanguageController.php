<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Language;
use App\Translation;
use File;
use Illuminate\Http\Request;

class LanguageController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data['languages'] = Language::all();

		return view( 'administration/languages/languages_list', $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'administration/languages/languages_create', [
			'translations' => Translation::all()->toArray()
		] );

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function store(
		Request $request
	) {
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show(
		$id
	) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$language = Language::findOrFail($id);
		$file    = fopen( dirname( getcwd() ) . '/resources/lang/'.$language->language_shortcut.'/translation.php', 'r' );
		$content = str_replace( [
			'<?php',
			'return',
			'[',
			'];'
		], '', fread( $file, filesize( dirname( getcwd() ) . '/resources/lang/'.$language->language_shortcut.'/translation.php' ) ) );
		fclose( $file );
		$content = str_replace( '\'', '', $content );
		$tmp      = explode( ',', addslashes( $content ) );
		$resource = [];
		$i        = 0;
		foreach ( $tmp as $translation ) {
			$tmp2 = explode( '=>', $translation );
			if ( sizeof( $tmp2 ) == 2 ) {
				// Translation is setted
				$resource[ trim( str_replace( '>', '', htmlspecialchars_decode( $tmp2[0] ) ) ) ] = trim( str_replace( ',', '', $tmp2[1] ) );
			} else {
				// Translation is not setted TODO

			}

		}

		return view( 'administration/languages/language_edit', [
			'translations' => Translation::all()->toArray(),
			'language'     => Language::findOrFail( $id ),
			'resource'     => $resource
		] );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		Language::update_language($id, $request->title, $request->shortcut, $request->key, $request->value);

		\Session::flash( 'success', "Jazyk bol úspešne upravený." );

		return redirect( 'admin/languages' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$language    = Language::findOrFail( $id );
		if ( $language->delete() ) {
			$data['status'] = 'delete-success';
		}

		return back();
	}
}
