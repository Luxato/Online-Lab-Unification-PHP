<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ActualitiesController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if ( \Session::has( 'applocale' ) ) {
			$locale = \Session::get( 'applocale' );
		} else {
			$locale = \Config::get( 'app.locale' );
		}
		\App::setlocale( $locale );
		echo $locale;
		/*SELECT * FROM actualities as a
JOIN languages as l ON a.language = l.id
JOIN news_
		categories as c ON a.category = c.id*/
		$actualities = DB::select(DB::raw("SELECT * FROM actualities as a
								JOIN languages as l ON a.language = l.id
								JOIN news_categories as c ON a.category = c.id"));
		return view( 'aktuality', [
			'actualities' => $actualities
		] );
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
	 * @return \Illuminate\Http\Response
	 */
	public function store( Request $request ) {
		//
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
		//
	}
}
