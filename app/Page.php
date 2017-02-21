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

	public static function create_file($name, $content) {
		//TODO check if same file exists if so return FALSE
		//TODO if does not exists create file, write content there and return TRUE

	}

	public static function select_all() {
		return Page::all();
	}

}
