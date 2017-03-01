<?php

namespace App\Http\Controllers;

use App\Language;
use App\Page;
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
	public $language = FALSE;

	public $todo = 0;

	public function __construct() {
		//$this->init_locale();
		$this->init_navigation();
		$this->init_section();
	}

	protected function init_navigation() {

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

}
