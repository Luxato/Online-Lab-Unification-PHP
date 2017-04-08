<?php

namespace App\Http\Controllers;

use App\Page;
use App\Setting;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
use Request;

class Controller extends BaseController {
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public $navigation = FALSE;
	public $section_id = FALSE;
	public $controller_name = FALSE;
	public $default_language = FALSE;

	public $todo = 0;

	public function __construct() {
		//$this->init_locale();
		//$this->init_section();
		$this->set_app_language();
	}

	protected function init_navigation($locale = 'sk') {
		$nav_links = DB::select( DB::raw( "SELECT * FROM feature_page as f
		JOIN navigation ON f.page_id = navigation.section_id
		JOIN (SELECT features.id as fid, features.title, features.content_file, features.controller, languages.language_shortcut FROM features
		JOIN languages ON features.language_id = languages.id WHERE languages.language_shortcut = '$locale') as sub ON f.feature_id = sub.fid  ORDER BY navigation.order, navigation.parent_id;" ) );

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

	}

	protected function init_section() {
		/*$action                = app( 'request' )->route()->getAction();
		$controller            = class_basename( $action['controller'] );
		$tmp                   = explode( '@', $controller );
		$this->controller_name = strtolower( $tmp[0] );
		$this->section_id      = DB::table( 'navigation' )
		                           ->where( 'controller', Request::segment(1) )
		                           ->value( 'section_id' );*/
	}

/*	protected function init_locale() {
		if ( \Session::has( 'applocale' ) ) {
			$locale = \Session::get( 'applocale' );
		} else {
			$locale = \Config::get( 'app.fallback_locale' );
		}

		\App::setlocale( $locale );
		$this->language = $locale;
		echo "jazyk je $locale";
	}*/
	public function set_app_language() {
		$this->default_language = Setting::all()[3]->setting_value;
	}

	public function get_default_lang() {
		return $this->default_language;
	}
}
