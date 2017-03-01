<?php

namespace App\Http\Controllers\Administration;

use App\Feature;
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
		//$this->middleware( 'auth' );
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
		$data['pages'] = Page::with( 'language' )->get();

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
		echo '<pre>';
		print_r( $request->all() );
		echo '</pre>';

		echo '<pre>';
		print_r( Page::find( 4 )->feature()->get() );
		echo '</pre>';
		$inputs = [
			'title'       => 'name',
			'controller'  => 'url',
			'language_id' => 'language'
		];
		$page   = new Page;
		$page->save();
		$new_features = [];
		for ( $i = 0; $i < sizeof( $request['name'] ); $i ++ ) {
			$feature = new Feature();
			foreach ( $inputs as $column => $input ) {
				$feature->{$column} = $request[ $input ][ $i ];
			}
			$language_shortcut     = Language::findOrFail( $request['language'][ $i ] )->language_shortcut;
			$feature->content_file = $request['url'][ $i ] . '_' . $language_shortcut . '.blade.php';
			$this->create_page_file($feature->content_file, $request['url'][$i], $request['cont'][$i]);
			$feature->save();
			$new_features[] = $feature->id;
		}
		$page->feature()->sync( $new_features );

		Session::flash( 'success', "Stránka bola úspešne vytvorená." );

		return redirect( 'admin/pages' );
	}

	public function create_page_file( $file_name, $title, $content ) {
		$template     = '
@extends(\'master\')

@section(\'title\')
	' . $title . '
@stop

@section(\'content\')
    ' . $content . '
@stop';
		$created_page = fopen( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $file_name, "w" );
		fwrite( $created_page, $template );
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
