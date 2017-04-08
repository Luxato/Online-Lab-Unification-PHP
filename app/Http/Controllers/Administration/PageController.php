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
		$this->middleware( 'auth' );
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$languages = Language::all()->toArray();
		$pages     = Page::with( 'feature' )->get()->toArray();

		foreach ( $pages as &$page ) {
			foreach ( $page['feature'] as &$feature ) {
				foreach ( $languages as $language ) {
					if ( $feature['language_id'] == $language['id'] ) {
						$feature['language'] = $language['language_title'];
					}
				}
			}
		}

		return view( 'administration/pages_list', [ 'pages' => $pages ] );
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
			$language_shortcut = Language::findOrFail( $request['language'][ $i ] )->language_shortcut;

			if ( $request->get( 'noContent' ) !== 'on' ) {
				$feature->content_file = $request['url'][0] . '_' . $language_shortcut;
				$this->create_page_file( $feature->content_file . '.blade.php', $request['url'][ $i ], $request['cont'][ $i ] );
			}
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
		chmod( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $file_name, 0777 );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {

		return view( 'administration/pages_edit' );
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
		$page      = Page::find( $id );
		$to_delete = [];
		foreach ( $page->feature()->get()->toArray() as $feature ) {
			$to_delete[] = Feature::find( $feature['id'] )->get()->toArray()[0]['content_file'];
		}
		if ( $page->feature()->detach() ) {
			$page->delete();
			/*foreach ( $to_delete as $feature ) {
				$tmp_feature = Feature::findOrFail( $feature );
				var_dump( $tmp_feature->delete() );
			}*/
			foreach($to_delete as $content_file) {
				unlink( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $content_file);
			}

			Session::flash( 'success', "Stránka bola úspešne zmazaná." );

			return redirect( 'admin/pages' );
		}
	}
}
