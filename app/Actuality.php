<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Actuality extends Model {
	protected $table = 'actualities';

	public function language() {
		return $this->hasOne('App\Language');
	}

	public function category() {
		return $this->hasOne('App\Category');
	}

	public static function getAll() {
		if ( \Session::has( 'applocale' ) ) {
			$locale = \Session::get( 'applocale' );
		} else {
			$locale = \Config::get( 'app.locale' );
		}
		return DB::select( DB::raw( "SELECT a.id, a.name, a.content, a.thumbnail_path, a.created_at, l.language_title ,l.language_shortcut, c.id as catID ,c.name as catname FROM actualities as a
									JOIN languages as l ON a.language = l.id
									JOIN categories as c ON a.category = c.id
									WHERE l.language_shortcut = '$locale'" ) );
	}

	public static function getAll_admin() {
		return DB::select( DB::raw( "SELECT a.id, a.name, a.content, a.thumbnail_path, a.created_at, l.language_title ,l.language_shortcut, c.id as catID ,c.name as catname FROM actualities as a
									JOIN languages as l ON a.language = l.id
									JOIN categories as c ON a.category = c.id" ) );
	}

	public static function getActuality($id) {
		return DB::select( DB::raw( "SELECT a.id, a.name, a.content, a.thumbnail_path, a.created_at, l.language_title ,l.language_shortcut, c.id as catID ,c.name as catname FROM actualities as a
									JOIN languages as l ON a.language = l.id
									JOIN categories as c ON a.category = c.id
									WHERE a.id = $id" ) );
	}

}
