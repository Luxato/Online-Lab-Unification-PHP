<?php

namespace App\Http\Controllers;

use App\Language;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Page;

class Homepage extends Controller {

	public $navigation = [];

	/*public function index(Request $request, $locale = NULL) {
		// Set up language
		if (empty($locale)) {
		    $locale = config('app.fallback_locale');
		}
		app()->setLocale($locale);
		$data['navigation'] = $this->navigation;
		$data['section_id'] = $this->section_id;

		return view( 'welcome', $data );
	}*/

	public function index( Request $request, $slug = NULL ) {
		if ( \Session::has( 'applocale' ) ) {
			$locale = \Session::get( 'applocale' );
		} else {
			$locale = \Config::get( 'app.locale' );
		}
		\App::setlocale( $locale );

		$nav_links = DB::select( DB::raw( "SELECT * FROM feature_page as f
		JOIN navigation ON f.page_id = navigation.section_id
		JOIN (SELECT features.id as fid, features.title, features.content_file, features.controller, languages.language_shortcut FROM features
		JOIN languages ON features.language_id = languages.id WHERE languages.language_shortcut = '$locale') as sub ON f.feature_id = sub.fid;" ) );

		foreach ( $nav_links as $link ) {
			if ( empty( $link->parent_id ) ) {
				$this->navigation[ $link->section_id ] = $link;
				foreach ( $nav_links as $key2 => $value2 ) {
					if ( $link->section_id == $value2->parent_id ) {
						foreach ( $nav_links as $key => $value3 ) {
							if ( $value2->section_id == $value3->parent_id ) {
								$value2->children[] = $value3;
								unset( $nav_links[ $key ] );
							}
						}
						$this->navigation[ $link->section_id ]->children[] = $value2;
						unset( $nav_links[ $key2 ] );
					}
				}

			}
		}

		$data['navigation'] = $this->navigation;
		$data['section_id'] = $this->section_id;
		$data['languages']  = Language::all()->toArray();
		if ( ! isset( $slug ) ) {
			// TODO change this to dynamic
			$blade = 'user_created_pages/' . 'aktuality_sk';
		} else {
			foreach ( $this->navigation as $link ) {
				if ( $link->controller == trim( $slug ) ) {
					$blade = 'user_created_pages/' . $link->content_file;
					break;
				}
				if (isset($link->children)) {
					foreach($link->children as $child) {
						if ( $child->controller == trim( $slug ) ) {
							$blade = 'user_created_pages/' . $child->content_file;
							break;
						}
						if (isset($child->children)) {
							foreach($child->children as $subchild) {
								if ( $subchild->controller == trim( $slug ) ) {
									$blade = 'user_created_pages/' . $subchild->content_file;
									break;
								}
							}
						}
					}
				}
			}
			if ( ! isset( $blade ) ) {
				abort( 404 );
			}

		}

		return view( $blade, $data );
	}

	public function set_language( $lang ) {
		foreach ( Language::all()->toArray() as $language ) {
			if ( $language['language_shortcut'] = $lang ) {
				\Session::set( 'applocale', $lang );
			}
		}

		return redirect( '/' );
	}
}
