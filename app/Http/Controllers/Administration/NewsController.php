<?php

namespace App\Http\Controllers\Administration;

use App\Actuality;
use Session;
use App\Http\Controllers\Controller;

use App\News_categorie;
use App\Language;
use Illuminate\Http\Request;

class NewsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		return view( 'administration/news_create', [
			'categories' => News_categorie::all(),
			'languages'  => Language::all()
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
		$actuality           = new Actuality();
		$actuality->name     = $request->name;
		$actuality->content  = $request->cont;
		$actuality->language = $request->language[0];
		$actuality->category = $request->category;
		if ( $request->infinity !== 'on' ) {
			$actuality->from = $request->startDate;
			$actuality->to   = $request->endDate;
		}
		if ( $filename = $this->uploadFile( $actuality, $request->file( 'thumbnail' ) ) ) {
			$actuality->thumbnail_path = $filename;
		}
		$actuality->save();

		Session::flash( 'success', "Aktualita bola úspešne vytvorená." );

		return redirect( 'admin/news-categories' );
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

	private function uploadFile( $actuality, $file ) {
		if ( ! $file ) {
			return FALSE;
		}
		if ( $file || ! $file->isValid() ) {
			$filepath   = storage_path( 'uploads/' . $actuality->id );
			$extenstion = $file->getClientOriginalExtension();
			//$filename   = $file->getClientOriginalName() . '_' . time();
			$filename = str_replace(
				".$extenstion",
				"-" . time() . ".$extenstion",
				$file->getClientOriginalName()
			);

			$file->move( $filepath, $filename );

			return 'storage/uploads/' . $filename;
		}
	}
}
