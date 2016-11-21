<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {
	protected $fillable = [ 'language_title', 'language_shortcut' ];

	public static function select_all() {
		$languages = Language::all()->toArray();

		return $languages;
	}

	public static function _create( $title, $shortcut ) {
		// TODO check if its not duplicate
		// Insert new language to Database
		$language                    = new Language;
		$language->language_title    = $title;
		$language->language_shortcut = $shortcut;
		if ( $language->save() ) {
			// If database insert was succesful lets create new directory and file for lang
			//mkdir( dirname( getcwd() ) . '/resources/lang/' . $shortcut, 0777 );
			try {
				mkdir( dirname( getcwd() ) . '/resources/lang/' . $shortcut, 0777 );
			} catch( \Exception $e ) {
				// TODO log this somewehre
				echo 'Caught exception: ', $e->getMessage(), "\n";
			}
			$myfile = fopen( dirname( getcwd() ) . '/resources/lang/' . $shortcut . '/' . $shortcut . '.php', "w" );

		}
	}

	public static function remove() {

	}

	public static function create_language() {

	}
}
