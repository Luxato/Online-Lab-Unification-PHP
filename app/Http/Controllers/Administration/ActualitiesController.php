<?php

namespace App\Http\Controllers\Administration;

use App\Actuality;
use App\Category;
use Session;
use App\Http\Controllers\Controller;

use App\News_categorie;
use App\Language;
use Illuminate\Http\Request;

class ActualitiesController extends Controller {

	public function __construct() {
		$this->middleware( 'auth' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view( 'administration/actualities/actualities_list', [
			'actualities' => Actuality::getAll_admin()
		] );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'administration/actualities/actualities_create', [
			'categories' => Category::all(),
			'languages'  => Language::all()
		] );
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

		// Create category
		if ( $request->category == 'new' ) {
			// If we have to create new category
			$category       = new Category();
			$category->name = $request->newCategory;
			$category->save();
			$actuality->category = $category->id;
		} else {
			$actuality->category = $request->category;
		}

		/*if ( $request->infinity !== 'on' ) {
			$actuality->from = $request->startDate;
			$actuality->to   = $request->endDate;
		}*/
		if ( $filename = $this->uploadFile( $actuality, $request->file( 'thumbnail' ) ) ) {
			$actuality->thumbnail_path = 'uploads/' . $filename;
		} else {
			$actuality->thumbnail_path = 'uploads/default.jpg';
		}
		$actuality->save();

		Session::flash( 'success', "Aktualita bola úspešne vytvorená." );

		return redirect( 'admin/actualities' );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {


		return view( 'administration/actualities/actualities_edit', [
			'categories' => Category::all(),
			'languages'  => Language::all(),
			'actuality'  => Actuality::findOrFail( $id )
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
		$actuality           = Actuality::findOrFail( $id );
		$actuality->name     = $request->name;
		$actuality->content  = $request->cont;
		$actuality->language = $request->language;

		// Create category
		if ( $request->category == 'new' ) {
			// If we have to create new category
			$category       = new Category();
			$category->name = $request->newCategory;
			$category->save();
			$actuality->category = $category->id;
		} else {
			$actuality->category = $request->category;
		}

		if ( $filename = $this->uploadFile( $actuality, $request->file( 'thumbnail' ) ) ) {
			$actuality->thumbnail_path = 'uploads/' . $filename;
		}

		$actuality->save();

		Session::flash( 'success', "Aktualita bola úspešne upravená." );

		return redirect( 'admin/actualities' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return bool
	 */
	public function destroy( $id ) {
		$actuality   = Actuality::findOrFail( $id );
		$actualities = Actuality::where( 'category', $actuality->category )->get();
		$category = Category::find($actuality->category);
		$delete_category = FALSE;
		if (sizeof($actualities) == 1) {
			$delete_category = TRUE;
		}
		if ( $actuality->delete() ) {
			if ( $actuality->thumbnail_path != 'uploads/default.jpg' ) {
				if ( file_exists( dirname( getcwd() ) . '/public/' . $actuality->thumbnail_path ) ) {
					unlink( dirname( getcwd() ) . '/public/' . $actuality->thumbnail_path );
				}
			}
			if ($delete_category) {
				$category->delete();
			}

			Session::flash( 'success', "Aktualita bola úspešne vymazaná." );

			return redirect( 'admin/actualities' );
		}
	}

	private function uploadFile( $actuality, $file ) {
		if ( ! $file ) {
			return FALSE;
		}
		if ( $file || ! $file->isValid() ) {
			$filepath   = public_path( 'uploads/' . $actuality->id );
			$extenstion = $file->getClientOriginalExtension();
			//$filename   = $file->getClientOriginalName() . '_' . time();
			$filename = str_replace(
				".$extenstion",
				"-" . time() . ".$extenstion",
				$file->getClientOriginalName()
			);

			$file->move( $filepath, $filename );

			return $filename;
		}
	}
}
