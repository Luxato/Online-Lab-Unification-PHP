<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;

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
		$data               = DB::table( 'navigation' )->where('parent_id', NULL)->get();
		$this->navigation = $data->toArray();
	}

	protected function init_section() {
		$action                = app( 'request' )->route()->getAction();
		$controller            = class_basename( $action['controller'] );
		$tmp                   = explode( '@', $controller );
		$this->controller_name = strtolower( $tmp[0] );
		$this->section_id      = DB::table( 'navigation' )
		                           ->where( 'controller', $this->controller_name )
		                           ->value( 'section_id' );
	}

}
