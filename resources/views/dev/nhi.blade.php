<h1>nhi's dev page</h1>

<h2>Events:</h2>
@foreach ($events as $event) 
	<spam>{{$event->name}}, {{$event->datetime}}</spam></br>
@endforeach

<h2>Patrons:</h2>
@foreach ($patrons as $patron) 
	<img src="{{$patron->picurl}}" alt="patronPic" height="42" width="42"> 
	<spam>{{$patron->name}}, {{$patron->address}}, {{$patron->suburb}}</spam></br>
@endforeach