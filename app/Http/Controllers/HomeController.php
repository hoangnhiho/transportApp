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
	public function getEventList()
	{
		$events = DB::table('events')->get();
		return view('dev.showAll', ['events' => $events, ]);
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function show($eventID)
	{
		$patrons = DB::table('patrons')->get();
		$events = DB::table('events')->get();
		$nearbySets = DB::table('nearby_sets')->get();
		$patronsInEvent = DB::table('event_patron')
			->where('event_id', $eventID)
	    	->join('patrons', 'event_patron.patron_id', '=', 'patrons.id')
			->get();
		
		return view('dev.transport', ['eventID' => $eventID, 'patronsInEvent' => $patronsInEvent, 'events' => $events, 'nearbySets' => $nearbySets]);
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
		$nearbySets = DB::table('nearby_sets')->select('nearbyset')->get();
		$PatronsInEvent = DB::table('event_patron')
				->where('event_id', $eventID)
            	->join('patrons', 'event_patron.patron_id', '=', 'patrons.id')
				->get();
		return array_merge($PatronsInEvent, $nearbySets);
	}

	/**
	 * getPatronsInEvent = array of objects with patron's details going to the event
	 *
	 * @return Array of Objects
	 */
	public function toggleEventPatron($eventID, $patronID, $toggleID)
	{
		DB::table('event_patron')
            ->where('event_id', $eventID)
            ->where('patron_id', $patronID)
            ->update(['softDelete' => $toggleID]);
        if ($toggleID == "0"){
			DB::table('event_patron')
	            ->where('event_id', $eventID)
	            ->where('patron_id', $patronID)
	            ->update(['carthere' => 'none']);
			DB::table('event_patron')
	            ->where('event_id', $eventID)
	            ->where('patron_id', $patronID)
	            ->update(['carback' => 'none']);
	    }
	}
	
	/**
	 * getPatronsInEvent = array of objects with patron's details going to the event
	 *
	 * @return Array of Objects
	 */
	public function postCarThere($eventID, $patronID, $driverID)
	{
		DB::table('event_patron')
            ->where('event_id', $eventID)
            ->where('patron_id', $patronID)
            ->update(['carthere' => $driverID]);
        //return "eventID = ".$eventID." | patronID = ".$patronID." | driverID = ".$driverID;
	}

	/**
	 * getPatronsInEvent = array of objects with patron's details going to the event
	 *
	 * @return Array of Objects
	 */
	public function postCarBack($eventID, $patronID, $driverID)
	{
		DB::table('event_patron')
            ->where('event_id', $eventID)
            ->where('patron_id', $patronID)
            ->update(['carback' => $driverID]);
        //return "eventID = ".$eventID." | patronID = ".$patronID." | driverID = ".$driverID;
	}

}
