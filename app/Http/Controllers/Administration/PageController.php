<?php

namespace App\Http\Controllers\Administration;

use App\Feature;
use App\Http\Controllers\Controller;
use DaveJamesMiller\Breadcrumbs\Exception;
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

		return view( 'administration/pages/pages_list', [ 'pages' => $pages ] );
	}

	/**
	 * Method for reodering navigation.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function reorder() {
		$this->init_navigation();
		$data['navigation'] = $this->navigation;
		$ids                = [];
		foreach ( $data['navigation'] as $key1 => $page ) {
			$ids[] = $page->page_id;
			if ( isset( $page->children ) ) {
				foreach ( $page->children as $key2 => $subpage ) {
					$ids[] = $subpage->page_id;
					if ( isset( $subpage->children ) ) {
						foreach ( $subpage->children as $key3 => $subsubpage ) {
							if ( in_array( $subsubpage->page_id, $ids ) ) {
								unset( $data['navigation'][ $key1 ]->children[ $key2 ]->children[ $key3 ] );
							}
							$ids[] = $subsubpage->page_id;
						}
					}
				}
			}
		}

		return view( 'administration/pages/navigation_reorder', $data );
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view( 'administration/pages/pages_create', [
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
				$this->create_page_file( $feature->content_file . '.blade.php', $request['name'][ $i ], $request['cont'][ $i ], $request['seo_description'][ $i ], $request['keywords'][ $i ] );
			}
			$feature->save();
			$new_features[] = $feature->id;
		}
		$page->feature()->sync( $new_features );


		Session::flash( 'success', "Stránka bola úspešne vytvorená." );

		return redirect( 'admin/pages' );
	}

	public function create_page_file( $file_name, $title, $content, $description, $keywords ) {
		$template     = '
@extends(\'master\')

@section(\'title\') ' . $title . ' @stop

@section(\'seo_description\')' . $description . ' @stop

@section(\'keywords\')' . $keywords . ' @stop

@section(\'content\')
    ' . htmlspecialchars_decode( htmlspecialchars( $content ) ) . '
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
		$page      = Page::with( 'feature' )->findOrFail( $id )->toArray();
		$languages = Language::all()->toArray();
		foreach ( $page['feature'] as &$features ) {
			try {
				$fileName = $features['content_file'] . '.blade.php';
				if ( ! file_exists( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $fileName ) ) {
					continue;
				}
			} catch( Exception $e ) {

			}
		}

		return view( 'administration/pages/pages_edit', [
			'page'      => $page,
			'languages' => $languages
		] );
	}

	public function show() {
		return redirect( 'admin/pages' );
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
		echo '<pre>';
		print_r( $request->all() );
		echo '</pre>';
		// Define allowed inputs
		$inputs          = [
			'title'       => 'name',
			'controller'  => 'url',
			'language_id' => 'language'
		];
		$page            = Page::findOrFail( $id );
		$to_rename       = [];
		$files_to_delete = [];
		$i               = 0;
		foreach ( $page->feature()->get()->toArray() as $feature ) {
			$feature_to_delete[] = Feature::find( $feature['pivot']['feature_id'] );
			$files_to_delete[]   = $feature_to_delete[ $i ]['content_file'];
			if ( $i != $request->get( 'originalSize' ) ) { // If we created new localization
				$to_rename[] = $feature_to_delete[ $i ]['content_file'];
			}
			$i ++;
		}
		echo '<pre>';
		print_r( $to_rename );
		echo '</pre>';
		//exit;
		if ( $page->feature()->detach() ) {
			// Delete old features
			foreach ( $feature_to_delete as $feature ) {
				$feature->delete();
			}
			$l = 0;
			for ( $i = 0; $i < sizeof( $request['name'] ); $i ++ ) {
				$feature = new Feature();
				foreach ( $inputs as $column => $input ) {
					$feature->{$column} = $request[ $input ][ $i ];
				}
				$language_shortcut = Language::findOrFail( $request['language'][ $i ] )->language_shortcut;
				if ( $request->get( 'noContent' ) !== 'on' ) {
					$feature->content_file = $request['url'][0] . '_' . $language_shortcut;
					if ( isset( $to_rename[ $i ] ) ) {
						if ( ( $key = array_search( $to_rename[ $i ], $files_to_delete ) ) !== FALSE ) {
							unset( $files_to_delete[ $key ] );
						}
						// Rename old files to new names
						rename(
							dirname( getcwd() ) . '/resources/views/user_created_pages/' . $to_rename[ $i ] . '.blade.php',
							dirname( getcwd() ) . '/resources/views/user_created_pages/' . $feature->content_file . '.blade.php'
						);
					} else {
						// Create file
						$this->create_page_file( $feature->content_file . '.blade.php', $feature->title, $request['cont'][ $l ], $request['seo_description'][ $l ], $request['keywords'][ $l ] );
						$l ++;
					}
				} else {
					$feature->controller = NULL;
				}
				$feature->save();
				$new_features[] = $feature->id;
				$page->feature()->attach( $feature->id );
			}
			foreach ( $files_to_delete as $file ) {
				if ( file_exists( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $file . '.blade.php' ) && $file ) {
					unlink( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $file . '.blade.php' );
				}
			}
			Session::flash( 'success', "Stránka bola úspešne upravená." );

			return redirect( 'admin/pages' );
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		$page      = Page::findOrFail( $id );
		$to_delete = [];
		$i         = 0;
		foreach ( $page->feature()->get()->toArray() as $feature ) {
			$feature_to_delete[] = Feature::find( $feature['pivot']['feature_id'] );
			$to_delete[]         = $feature_to_delete[ $i ]['content_file'];
			$i ++;
		}
		if ( $page->feature()->detach() ) {
			$page->delete();
			// Delete features
			foreach ( $feature_to_delete as $feature ) {
				$feature->delete();
			}
			foreach ( $to_delete as $content_file ) {
				if ( file_exists( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $content_file . '.blade.php' ) && $content_file ) {
					unlink( dirname( getcwd() ) . '/resources/views/user_created_pages/' . $content_file . '.blade.php' );
				}
			}

			Session::flash( 'success', "Stránka bola úspešne zmazaná." );

			return redirect( 'admin/pages' );
		}
	}
}
