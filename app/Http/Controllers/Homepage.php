<?php

namespace App\Http\Controllers;

use App\Actuality;
use App\Language;
use App\News_categorie;
use App\User;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Page;

class Homepage extends Controller {


	public function index( Request $request, $slug = NULL ) {

		if ( \Session::has( 'applocale' ) ) {
			$locale = \Session::get( 'applocale' );
		} elseif ( isset( $this->default_language ) ) {
			$locale = $this->default_language;
		} else {
			$locale = \Config::get( 'app.locale' );
		}
		\App::setlocale( $locale );

		if ( \Session::has( 'logged_user_id' ) ) {
			$data['user'] = User::findOrFail( \Session::get( 'logged_user_id' ) );
		}

		$this->init_navigation( $locale );

		$data['navigation'] = $this->navigation;
		/*echo '<pre>';
		print_r( $data['navigation'] );
		echo '</pre>';*/
		$data['section_id'] = $this->section_id;
		$data['languages']  = Language::all()->toArray();

		if ( $slug === 'aktuality' ) {
			$data['actualities'] = Actuality::getAll();
			$data['categories']  = [];
			$uniqueCat           = TRUE;
			foreach ( $data['actualities'] as $actuality ) {
				$uniqueCat = TRUE;
				foreach ( $data['categories'] as $category ) {
					if ( $category['id'] == $actuality->catID ) {
						$uniqueCat = FALSE;
					}
				}
				if ( $uniqueCat ) {
					$data['categories'][] = [
						'id'   => $actuality->catID,
						'name' => $actuality->catname
					];
				}
			}

			return view( 'aktuality', $data );
		}
		if ( ! isset( $slug ) ) {
			// TODO change this to dynamic
			$blade = 'default';
		} else {
			foreach ( $this->navigation as $link ) {
				if ( $link->controller == trim( $slug ) ) {
					$blade = 'user_created_pages/' . $link->content_file;
					break;
				}
				if ( isset( $link->children ) ) {
					foreach ( $link->children as $child ) {
						if ( $child->controller == trim( $slug ) ) {
							$blade = 'user_created_pages/' . $child->content_file;
							break;
						}
						if ( isset( $child->children ) ) {
							foreach ( $child->children as $subchild ) {
								if ( $subchild->controller == trim( $slug ) ) {
									$blade = 'user_created_pages/' . $subchild->content_file;
									break;
								}
							}
						}
					}
				}
			}
			if ( ! isset( $blade ) ) {
				abort( 404 );
			}

		}

		return view( $blade, $data );
	}

	public function set_language( $lang ) {
		foreach ( Language::all()->toArray() as $language ) {
			if ( $language['language_shortcut'] = $lang ) {
				\Session::set( 'applocale', $lang );
			}
		}

		return redirect( '/' );
	}

	public function aktuality( $id ) {
		$actualities = DB::select( DB::raw( "SELECT * FROM actualities
									WHERE id = '$id'" ) );

		return view( 'aktualita', [
			'actualities' => $actualities[0],
			'navigation'  => $this->navigation,
			'languages'   => Language::all()->toArray()
		] );

	}
}
