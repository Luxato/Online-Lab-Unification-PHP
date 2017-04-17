<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Language;
use App\Translation;


class Admin extends Controller {

	public function index() {
		return view( 'administration/dashboard' );
	}

	public function navigation() {
		$this->init_navigation();
		$data['navigation'] = $this->navigation;
		$ids = [];
		foreach ($data['navigation'] as $key1 => $page) {
			$ids[] = $page->page_id;
			if (isset($page->children)) {
			    foreach($page->children as $key2 => $subpage) {
				    $ids[] = $subpage->page_id;
				        if (isset($subpage->children)) {
					        foreach($subpage->children as $key3 => $subsubpage) {
					        	if (in_array($subsubpage->page_id, $ids)) {
					        	    unset($data['navigation'][$key1]->children[$key2]->children[$key3]);
					        	}
						        $ids[] = $subsubpage->page_id;
					        }
				        }
			    }
			}
		}
		return view( 'administration/navigation', $data );
	}

	public function languages() {
		$data['languages'] = Language::all();

		return view( 'administration/languages', $data );
	}

	public function create_lang() {
		return view( 'administration/create_language', [
			'translations' => Translation::all()->toArray()
		]);
	}

}
