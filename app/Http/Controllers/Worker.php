<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Language;
use App\Page;

class Worker extends Controller {
	// TODO do not use $_POST variable,
	// TODO backend validation
	// TODO move to own controller LanguageController
	protected function do_create_language() {
		$title    = $_POST['title'];
		$shortcut = $_POST['shortcut'];
		$keys   = $_POST['key'];
		$values = $_POST['value'];

		Language::_create( $title, $shortcut, $keys, $values );
		 \Session::flash( 'success', "Jazyk bol úspešne vytvorený." );

		return redirect( 'admin/languages' );
	}


	public function do_navigation_change_order() {
		// TODO VALIDATION
		$order_json        = $_POST['orderJSON'];
		$order_json        = json_decode( $order_json, TRUE );
		$i                 = 1; // First level.
		$k                 = 1; // Second level.
		$j                 = 1; // Third level.
		$pages_with_parent = [];
		// First level.
		foreach ( $order_json as $parent ) {
			$page        = Page::find( $parent['id'] );
			$page->order = $i;
			$page->save();
			// Second level.
			if ( isset( $parent['children'] ) ) {
				foreach ( $parent['children'] as $child ) {
					$pages_with_parent[]   = $child['id'];
					$child_page            = Page::find( $child['id'] );
					$child_page->order     = $k;
					$child_page->parent_id = $parent['id'];
					$child_page->save();
					$k ++;
					// Third level.
					if ( isset( $child['children'] ) ) {
						foreach ( $child['children'] as $subchild ) {
							$pages_with_parent[]   = $subchild['id'];
							$child_page            = Page::find( $subchild['id'] );
							$child_page->order     = $j;
							$child_page->parent_id = $child['id'];
							$child_page->save();
							$j ++;
						}
					}
				}
			}
			$i ++;
		}
		$pages_where_remove_parent = DB::table( 'navigation' )
		                               ->select( 'section_id' )
		                               ->whereNotIn( 'section_id', $pages_with_parent )
		                               ->get()
		                               ->toArray();
		foreach ( $pages_where_remove_parent as $selected_page ) {
			$page            = Page::find( $selected_page->section_id );
			$page->parent_id = NULL;
			$page->save();
		}

		return back();
	}
}
