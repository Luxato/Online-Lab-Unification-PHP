<?php

namespace App\Http\Controllers\Administration;

use App\Actuality;
use App\Http\Controllers\Controller;
use App\Language;
use App\Page;
use App\Translation;
use File;
use Illuminate\Http\Request;

class LanguageController extends Controller {

	public function __construct() {
		$this->middleware( 'auth' );
	}

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
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$language = Language::findOrFail( $id );
		$file     = fopen( dirname( getcwd() ) . '/resources/lang/' . $language->language_shortcut . '/translation.php', 'r' );
		$content  = str_replace( [
			'<?php',
			'return',
			'[',
			'];'
		], '', fread( $file, filesize( dirname( getcwd() ) . '/resources/lang/' . $language->language_shortcut . '/translation.php' ) ) );
		fclose( $file );
		$content  = str_replace( '\'', '', $content );
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
	public function update( Request $request, $id ) {
		Language::update_language( $id, $request->title, $request->shortcut, $request->key, $request->value );

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
	public function destroy( $id ) {
		// Delete respective pages, thier features and actualities.
		foreach ( Page::with( 'feature' )->get() as $page ) {
			$files_to_unlink = [];
			foreach ( $page->feature as $feature ) {
				if ( $feature->language_id == $id ) {
					if ( isset( $feature->content_file ) ) {
						$files_to_unlink[] = $feature->content_file;
					}
					// Detach feature.
					$page->feature()->detach( $feature->id );
					// Delete feature.
					$feature->delete();
					foreach ( $files_to_unlink as $content_file ) {
						unlink( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $content_file . '.blade.php' );
					}
				}
			}
			// If it was the last feature, remove page as well.
			if ( sizeof( $page->feature ) == 0 ) {
				$page->delete();
			}
		}
		// Unlink actualities thumbnails
		foreach ( Actuality::where( 'language', $id ) as $actuality ) {
			if ( $actuality->thumbnail_path == 'uploads/default.jpg' ) {
				continue;
			}
			if ( ! file_exists( dirname( getcwd() ) . '/public/' . $actuality->thumbnail_path ) ) {
				unlink( dirname( getcwd() ) . '/public/' . $actuality->thumbnail_path );
			}
		}
		$language = Language::findOrFail( $id );
		// Delete directory and file
		$directory = dirname( getcwd() ) . '/resources/lang/' . $language->language_shortcut;
		if ( is_file( $directory . '/translation.php' ) ) {
			unlink( $directory . '/translation.php' );
			rmdir($directory);
		}
		exit;
		// Delete lang
		if ( $language->delete() ) {
			\Session::flash( 'success', "Jazyk a všetky jeho súčasti boli úspešne zmazané." );
		}

		return back();
	}
}
