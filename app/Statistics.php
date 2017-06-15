<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Statistics extends Model {
	protected $table = 'statistics_logs';

	public static function get_statistics_no_longer_than( $days ) {
		$days = intval( $days );

		return json_decode( json_encode( \DB::select( "SELECT * FROM statistics_logs WHERE DATEDIFF(NOW(), created_at) < $days" ) ), TRUE );
	}
}
