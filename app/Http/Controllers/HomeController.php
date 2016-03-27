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
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		//return view('event/1');
		return redirect('event/1');
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

	public function moi()
	{
		$patrons = DB::table('patrons')->get();
		$eventID = DB::table('events')->first();
		$events = DB::table('events')->get();
		$patronsInEvent = DB::table('event_patron')
			->where('event_id', $eventID->id)
	    	->join('patrons', 'event_patron.patron_id', '=', 'patrons.id')
			->get();
		return view('dev.moi', ['patronsInEvent' => $patronsInEvent, 'events' => $events]);
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
		$nearbySets = DB::table('nearby_sets')->orderBy('id', 'asc')->select('nearbyset')->get();
		$nearbySetsID = DB::table('nearby_sets')->orderBy('id', 'asc')->select('id')->get();
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
            ->orderBy('name','asc')
			->get();
		return view('dev.transport', ['eventID' => $eventID, 'patronsInEvent' => $patronsInEvent, 'events' => $events, 'nearbySets' => $nearbySets]);
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function publicShow($eventID)
	{
		$patrons = DB::table('patrons')->get();
		$events = DB::table('events')->get();
		$nearbySets = DB::table('nearby_sets')->get();
		$patronsInEvent = DB::table('event_patron')
			->where('event_id', $eventID)
	    	->join('patrons', 'event_patron.patron_id', '=', 'patrons.id')
	    	->orderBy('name','asc')
			->get();
		return view('dev.transport', ['publicShow' => 'publicShow', 'eventID' => $eventID, 'patronsInEvent' => $patronsInEvent, 'events' => $events, 'nearbySets' => $nearbySets]);
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
		if ($input['password'] != 'secret') return 'You are not admin! stop trying to hack me!';
		if ($input['picurl'] == '' || !isset($input['picurl'])) $input['picurl'] = "https://s.ytimg.com/yts/img/avatar_720-vflYJnzBZ.png";
		$input['suburb'] = str_replace(' ', '', strtolower($input['suburb']));
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
		return redirect('eventAdmin/'.$eventID);
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
	public function getModalPatron($patronID)
	{
		$patron = DB::table('patrons')->where('id', '=', $patronID)->first();
		$patrons = DB::table('patrons')->get();
		return view('dev.showPatronModal', ['patron' => $patron,'patrons' => $patrons]);
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
	 * detele Patron.
	 *
	 * @return Response
	 */
	public function deletePatron($patronID)
	{
		patrons::where('id', $patronID)->delete();
		DB::table('event_patron')
            	->where( 'event_patron.patron_id', '=', $patronID)
				->delete();	
		return redirect('patron/');
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
	public function clearAllPatron($eventID)
	{
		$PatronsInEvent = DB::table('event_patron')
				->where('event_id', $eventID)
            	->update(['carthere' => 'none', 'carback' => 'none', 'softDelete' => '0']);
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
	public function changeEventPatronStatus($eventID, $patronID, $status)
	{
		if ($status == 'driving'){
			DB::table('event_patron')
	            ->where('event_id', $eventID)
	            ->where('patron_id', $patronID)
	            ->update(['softDelete' => '1', 'carthere' => 'driving' , 'carback' => 'driving']);
		}elseif ($status == 'any'){
			DB::table('event_patron')
	            ->where('event_id', $eventID)
	            ->where('patron_id', $patronID)
	            ->update(['softDelete' => '1', 'carthere' => 'any' , 'carback' => 'any']);
		}else{
			DB::table('event_patron')
	            ->where('event_id', $eventID)
	            ->where('patron_id', $patronID)
	            ->update(['softDelete' => '0', 'carthere' => 'none' , 'carback' => 'none']);
		}
		return 'yay';
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
            ->update(['carthere' => $driverID, 'carback' => $driverID]);
        if ($driverID != 'none'){
			DB::table('event_patron')
	            ->where('event_id', $eventID)
	            ->where('patron_id', $patronID)
	            ->update(['softDelete' => '1']);
        }
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
        if ($driverID != 'none'){
			DB::table('event_patron')
	            ->where('event_id', $eventID)
	            ->where('patron_id', $patronID)
	            ->update(['softDelete' => '1']);
        }
        //return "eventID = ".$eventID." | patronID = ".$patronID." | driverID = ".$driverID;
	}

}