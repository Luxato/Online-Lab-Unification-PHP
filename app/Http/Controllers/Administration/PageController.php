<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;
use App\Page;
use App\Language;

/**
 * REST Controller for database table pages
 */
class PageController extends Controller {

	public function __construct() {
		$this->middleware( 'auth' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		/*$data['pages'] = DB::table( 'navigation' )
		                   ->join( 'languages', 'navigation.language', '=', 'languages.id' )
		                   ->get()
		                   ->toArray();*/
		$data['pages'] = Page::with('language')->get();
/*echo '<pre>';
print_r( $data['pages'] );
echo '</pre>';*/
		return view( 'administration/pages_list', $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'administration/page_create', [
			'languages' => Language::all()
		] );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RESPONSE
	 */
	public function store( Request $request ) {
		$languages = [];
		foreach ( $request->all() as $name => $value ) {
			/*var_dump($key);
			echo "<br>";
			var_dump($value);
			echo "<br>";*/
			$tmp = explode( '-', $name );
			if (isset($tmp[1])) {
				if ( $tmp[1] == 'language' ) {
					$languages[] = $value;
				}
			}
		}
		$page               = new Page;
		$page->name         = $request->input('0-name');
		$page->controller   = $request->input('0-url');
		//$page->language     = $request->input('0-language');
		$page->content_file = $request->input('0-url') . '.blade.php';
		if ( $page->save() ) {
			// Save languages
			$page = Page::findOrFail( $page->section_id );
			$page->language()->sync( $languages );

			// If saving to database was succesfull let's create a file and put content in it.
			$content      = '
				@extends(\'master\')

				@section(\'title\')
					'.$request->input('0-name').'
				@stop

				@section(\'content\')
				    '.$request->input('0-cont').'
				@stop
			';
			$created_page = fopen( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $request->input('0-url') . '.blade.php', "w" );
			fwrite( $created_page, $content );
		}
		Session::flash( 'success', "Stránka bola úspešne vytvorená." );

		return redirect( 'admin/pages' );
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function show( $id ) {
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
		//
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
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$page = Page::findOrFail( $id );
		if ( $page->language()->sync( [] ) ) {
			$page->delete();
			if ( unlink( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $page->content_file ) ) {
				Session::flash( 'success', "Stránka bola úspešne vymazaná." );

				return redirect( 'admin/pages' );
			}
		}
	}
}
