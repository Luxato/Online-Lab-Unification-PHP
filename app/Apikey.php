<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Apikey extends Model {
	public function apikey() {
		return $this->belongsTo( 'App\User' );
	}
}
