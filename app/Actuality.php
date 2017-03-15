<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Actuality extends Model {
	protected $table = 'actualities';


	public static function getAll() {
		if ( \Session::has( 'applocale' ) ) {
			$locale = \Session::get( 'applocale' );
		} else {
			$locale = \Config::get( 'app.locale' );
		}
		return DB::select( DB::raw( "SELECT a.id, a.name, a.content, a.thumbnail_path, a.created_at, l.language_shortcut, c.id as catID ,c.name as catname FROM actualities as a
									JOIN languages as l ON a.language = l.id
									JOIN news_categories as c ON a.category = c.id
									WHERE l.language_shortcut = '$locale'" ) );
	}

}
