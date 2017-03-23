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

		return view( 'administration/languages', $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'administration/create_language', [
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
		$file = fopen( dirname( getcwd() ) . '/resources/lang/sk/translation.php', 'r');
		echo '<pre>'.fread($file,filesize(dirname( getcwd() ) . '/resources/lang/sk/translation.php')).'</pre>';
		fclose($file);
		exit;
		$content = str_replace('\'', '', $content);
		var_dump($content);
		$tmp     = explode( '=' , addslashes($content) );
		$translations = [];
		$i = 0;
		echo '<pre>';
		print_r( $tmp );
		echo '</pre>';
		foreach($tmp as $translation) {
			if ($i == 0) {
			    $i++;
			    continue;
			}
			$tmp2 = explode(',', $translation);
			if (sizeof($tmp2) == 2) {
				// Translation is setted
				/*echo str_replace('>', '',htmlspecialchars_decode($tmp2[0]));*/
				$translations[trim(str_replace('>', '', htmlspecialchars_decode($tmp2[0])))] = trim($tmp2[1]);
			} else {
				// Translation is not setted

			}

		}
		echo '<pre>';
		print_r( $translations );
		echo '</pre>';
		/*echo '<pre>';
		var_dump( $translations );
		echo '</pre>';*/

		return view( 'administration/languages/language_edit', [
			'translations' => Translation::all()->toArray(),
			'language'     => Language::findOrFail( $id )->first()
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
	public
	function update(
		Request $request, $id
	) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public
	function destroy(
		$id
	) {
		//
	}
}
