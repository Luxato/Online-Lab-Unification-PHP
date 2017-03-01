<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model {

	public $timestamps = false;

	public function page() {
		return $this->belongsToMany( 'App\Page' );
	}

	public function language()
	{
		return $this->hasOne('App\Language');
	}

}
