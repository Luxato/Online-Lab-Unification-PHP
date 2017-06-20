<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Statistics extends Model {
	protected $table = 'log_services';

	public static function get_statistics_no_longer_than( $days ) {
		$days = intval( $days );

		return json_decode( json_encode( \DB::select( "SELECT * FROM log_services WHERE DATEDIFF(NOW(), date) < $days" ) ), TRUE );
	}
}
