<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model {

	protected $table = 'navigation';
	protected $primaryKey = 'section_id';
	protected $fillable = [
		'name',
		'controller',
		'order',
		'parent_id',
		'active',
		'content_file'
	];

	public function language() {
		return $this->belongsToMany( 'App\Language' );
	}

	public static function select_all() {
		return Page::all();
	}

}
