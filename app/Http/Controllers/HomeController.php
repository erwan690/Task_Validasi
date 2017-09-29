<?php

namespace App\Http\Controllers;

use App\Aplication;
use App\User;
use Auth;
use Yajra\Datatables\Datatables;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$userid = Auth::user()->id;
		$data = Aplication::where('user_id', $userid)->get();
		return view('home')->with('cek', $data);
	}
	public function get_users(Datatables $datatables) {
		$builder = User::with('aplication')->select('id', 'name', 'email');

		return $datatables->eloquent($builder)
			->addColumn('filename', function (User $user) {
				return $user->aplication ? $user->aplication->filename : '';
			})
			->addColumn('action', function (User $user) {
				return '<a class="btn btn-xs btn-success" href="javascript:void(0)" title="Valid" onclick="valid_data(' . "'" . $user->id . "'" . ')"><i class="glyphicon glyphicon-edit"></i> Valid</a>' . '<a class="btn btn-xs btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_data(' . "'" . $user->id . "'" . ')"><i class="glyphicon glyphicon-trash"></i> Hapus</a>';})
			->make(true);
	}

}
