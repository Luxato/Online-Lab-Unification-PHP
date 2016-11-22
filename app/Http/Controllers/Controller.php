<?php

namespace App\Http\Controllers;

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

	public function __construct() {
		$this->init_navigation();
		$this->init_section();
	}

	protected function init_navigation() {
		$nav_links        = DB::table( 'navigation' )
								->orderBy( 'parent_id' )
								->orderBy( 'order' )
								->get()->toArray();
		$this->navigation = [];
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
		/*$time = microtime( TRUE ) - $_SERVER["REQUEST_TIME_FLOAT"];
		echo "Process Time: {$time}";*/
	}

	protected function init_section() {
		$action                = app( 'request' )->route()->getAction();
		$controller            = class_basename( $action['controller'] );
		$tmp                   = explode( '@', $controller );
		$this->controller_name = strtolower( $tmp[0] );
		$this->section_id      = DB::table( 'navigation' )
		                           ->where( 'controller', Request::segment(1) )
		                           ->value( 'section_id' );
	}

}
