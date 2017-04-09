<?php

namespace App\Http\Controllers\Administration;

use App\Apikey;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$users = User::all()->where( 'type', 'user' );

		return view( 'administration/users/users_list', [ 'users' => $users ] );
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function edit( $id ) {
		$user = User::findOrFail($id);

		return view( 'administration/users/users_edit', [ 'user' => $user ] );
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int                      $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update( Request $request, $id ) {
		$user = User::findOrFail($id);
		$user->name = $request->get('name');
		$user->email = $request->get('email');
		if ($user->password != '') { // @intentionally !=
			$user->password = \Hash::make($request->get('newPassword'));
		}
		if ($request->get('apikey')) {
			if ($apikey = $user->apikey) {
				// Remove previous APIkey
				$apikey->delete();
			}
			// Create new APIkey
			$apikey = new Apikey();
			$apikey->key = $request->get('apikey');
			$apikey->user_id = $id;
			$apikey->save();
		}
		$user->save();
		\Session::flash( 'success', "Užívateľ ". $user->name ." bol úspešne upravený." );

		return redirect( 'admin/users' );
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function destroy( $id ) {
		if ($id === 0) { // admin can not be deleted
			return back();
		}
		$user = User::findOrFail( $id );
		$user->delete();
		\Session::flash( 'success', "Užívateľ bol úspešne zmazaný." );

		return back();
	}
}
