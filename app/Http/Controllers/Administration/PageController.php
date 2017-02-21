<?php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Page;

class PageController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$data['pages'] = DB::table( 'navigation' )
		                   ->join( 'languages', 'navigation.language', '=', 'languages.id' )
		                   ->get()
		                   ->toArray();

		return view( 'administration/pages_list', $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
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
		$page               = new Page;
		$page->name         = $request->name;
		$page->controller   = $request->url;
		$page->language     = $request->language;
		$page->content_file = $request->url . '.php';
		if ( $page->save() ) {
			// If saving to database was succesfull let's create a file and put content in it.
			$created_page = fopen( dirname( getcwd() ) . '/resources/custom_pages/' . $request->url . '.php', "w" );
			fwrite( $created_page, $request->cont );
		}

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
		$language = Page::findOrFail( $id );
	}
}
