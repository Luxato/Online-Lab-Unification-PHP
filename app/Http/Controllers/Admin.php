<?php

namespace App\Http\Controllers;

use App\Statistics;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Language;
use App\Translation;


class Admin extends Controller {

	public function __construct() {
		$this->middleware( 'auth' );
	}

	public function index() {
		if (isset($_GET['days'])) {
			if ($_GET['days'] != 'all') {
				$data  = Statistics::get_statistics_no_longer_than($_GET['days']);
			} else {
				$data  = Statistics::all()->toArray();
			}
		} else {
			$data  = Statistics::all()->toArray();
		}
		$stats = [];
		foreach ( $data as &$value ) {
			if ( ! sizeof( $stats ) ) {
				$stats[] = [
					'service' => $value['service'],
					'counter' => 1
				];
			} else {
				$new = TRUE;
				foreach ( $stats as $key2 => $value2 ) {
					if ( $value2['service'] == $value['service'] ) {
						$stats[ $key2 ]['counter'] ++;
						$new = FALSE;
					}
				}
				if ( $new ) {
					$stats[] = [
						'service' => $value['service'],
						'counter' => 1
					];
				}
			}

		}

		return view( 'administration/dashboard', [
			'statistics' => $stats
		] );
	}

	public function create_lang() {
		return view( 'administration/create_language', [
			'translations' => Translation::all()->toArray()
		] );
	}

}
