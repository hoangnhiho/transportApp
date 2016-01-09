<?php namespace App\Http\Controllers;

use DB;
use Request;
use App\patrons;
use App\Http\Controllers\Controller;

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
	public function generateNearbySet()
	{
		$patrons = DB::table('patrons')->get();
		$events = DB::table('events')->get();
		$nearbySets = DB::table('nearby_sets')->select('nearbyset')->get();
		$nearbySetsID = DB::table('nearby_sets')->select('id')->get();
		return view('dev.generateNearbySet', ['patrons' => $patrons, 'events' => $events, 'nearbySets' => $nearbySets, 'nearbySetsID'=>$nearbySetsID]);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function getPetronList()
	{
		$patrons = DB::table('patrons')->get();
		return view('dev.showAllPatrons', ['patrons' => $patrons ]);
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
	public function createNearbySet($nearbyset)
	{
		$nearbyset = str_replace("-",",",$nearbyset);
		DB::table('nearby_sets')->insert(['nearbyset' => $nearbyset]);
		return redirect('generateNearbySet/');
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function deleteNearbySet($nearbyset)
	{
		DB::table('nearby_sets')->where('id', $nearbyset)->delete();
		return redirect('generateNearbySet/');
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function createPatron($eventID, Request $request)
	{
		$input = Request::all();
		$newPatron = patrons::create($input);

		$events = DB::table('events')->get();

		foreach ($events as $event){
			$patronsInEvent = DB::table('event_patron')
				->insert([
				    'event_id' => $event->id, 
				    'patron_id' => $newPatron->id,
				    'carthere' => 'any', 
				    'carback' => 'any', 
				    'leavingtime' => 'na',
				    'softDelete' => '1'
				]);
		}
		return redirect('event/'.$eventID);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function showPatron($patronID)
	{
		$patron = DB::table('patrons')->where('id', '=', $patronID)->first();
		$patrons = DB::table('patrons')->get();
		return view('dev.showPatron', ['patron' => $patron,'patrons' => $patrons]);
	}
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function editPatron(Request $request, $patronID)
	{
		$input = Request::all();
		$patron=patrons::find($patronID);
		$input['suburb'] = str_replace(' ', '', strtolower($input['suburb']));
		$patron->fill($input);
		$patron->save();
		return redirect('patron/'.$patronID);
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
	    }elseif ($toggleID == "1"){
			DB::table('event_patron')
	            ->where('event_id', $eventID)
	            ->where('patron_id', $patronID)
	            ->update(['carthere' => 'any']);
			DB::table('event_patron')
	            ->where('event_id', $eventID)
	            ->where('patron_id', $patronID)
	            ->update(['carback' => 'any']);
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
