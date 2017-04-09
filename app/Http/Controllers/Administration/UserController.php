<?php

namespace App\Http\Controllers\Administration;

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
		//
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
