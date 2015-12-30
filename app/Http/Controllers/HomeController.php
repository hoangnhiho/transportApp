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
		$patrons = DB::table('patrons')->get();
		$eventID = DB::table('events')->first();
		$events = DB::table('events')->get();
		$patronsInEvent = DB::table('event_patron')
			->where('event_id', $eventID->id)
	    	->join('patrons', 'event_patron.patron_id', '=', 'patrons.id')
			->get();
		return view('dev.joel', ['patronsInEvent' => $patronsInEvent, 'events' => $events]);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function nhi()
	{
		$patrons = DB::table('patrons')->get();
		$eventID = DB::table('events')->first();
		$events = DB::table('events')->get();
		$patronsInEvent = DB::table('event_patron')
			->where('event_id', $eventID->id)
	    	->join('patrons', 'event_patron.patron_id', '=', 'patrons.id')
			->get();
		return view('dev.nhi', ['patronsInEvent' => $patronsInEvent, 'events' => $events]);
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

	/**
	 * getPatronsInEvent = array of objects with patron's details going to the event
	 *
	 * @return Array of Objects
	 */
	public function getPatronsInEvent($eventID)
	{
		$PatronsInEvent = DB::table('event_patron')
				->where('event_id', $eventID)
				->where('softdelete', '=', '1')
            	->join('patrons', 'event_patron.patron_id', '=', 'patrons.id')
				->get();
		return $PatronsInEvent;
	}


}
