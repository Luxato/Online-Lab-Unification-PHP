<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {
	protected $fillable = [ 'language_title', 'language_shortcut' ];

	public static function _create( $title, $shortcut, $keys, $values ) {
		// TODO check if its not duplicate
		// Insert new language to Database
		$language                    = new Language;
		$language->language_title    = $title;
		$language->language_shortcut = $shortcut;
		if ( $language->save() ) {
			// If database insert was succesful lets create new directory and file for lang
			try {
				mkdir( dirname( getcwd() ) . '/resources/lang/' . $shortcut, 0777 );
			} catch( \Exception $e ) {
				// Todo log this somewehre
				/*echo 'Caught exception: ', $e->getMessage(), "\n";*/
			}
			$myfile = fopen( dirname( getcwd() ) . '/resources/lang/' . $shortcut . '/translation.php', "w" );
			$template = '';
			$template .= "<?php return [";
			for ($i = 0; $i < sizeof($keys); $i++) {
				if ($values[$i] == '' || empty($values[$i])) {
				    continue;
				}
				$template .= "'$keys[$i]' => '$values[$i]',";
			}
			$template .= "];";
			fwrite( $myfile, $template );
		}
	}

	public static function update_language($id, $title, $shortcut, $keys, $values) {
		// TODO check if its not duplicate
		$language                    = Language::findOrFail($id);
		$language->language_title    = $title;
		$language->language_shortcut = $shortcut;

		if ( $language->save() ) {
			// If database insert was succesful lets create new directory and file for lang
			try {
				mkdir( dirname( getcwd() ) . '/resources/lang/' . $shortcut, 0777 );
			} catch( \Exception $e ) {
				// Todo log this somewehre
				/*echo 'Caught exception: ', $e->getMessage(), "\n";*/
			}
			$myfile = fopen( dirname( getcwd() ) . '/resources/lang/' . $shortcut . '/translation.php', "w" );
			$template = '';
			$template .= "<?php return [";
			for ($i = 0; $i < sizeof($keys); $i++) {
				if ($values[$i] == '' || empty($values[$i])) {
					continue;
				}
				$template .= "'$keys[$i]' => '$values[$i]',";
			}
			$template .= "];";
			fwrite( $myfile, $template );
		}
	}

	public static function create_language() {

	}
}
