<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
	protected $table = 'news_categories';
	public $timestamps = false;



/*public function getSelectedCategories() {
	echo '<pre>';
	print_r( Actuality::all() );
	echo '</pre>';
	$actualities = Actuality::all();
	foreach ($actualities as $actuality) {

	}
}*/

}