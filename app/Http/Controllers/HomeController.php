<?php namespace App\Http\Controllers;

use DB;


class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('home');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function joel()
	{
		return view('dev.joel');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function nhi()
	{
		$patrons = DB::table('patrons')->get();
		$events = DB::table('events')->get();
		return view('dev.nhi', ['patrons' => $patrons, 'events' => $events]);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function moi()
	{
		return view('dev.moi');
	}
}
