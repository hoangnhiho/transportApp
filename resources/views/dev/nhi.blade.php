@extends('app')

@section('content')
<h1>nhi's dev page, Like a Boss</h1>
<div class='row'>
	<div class="col-md-2">
		<div class="panel panel-default">
			<div class="panel-heading">Events</div>
			<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				@foreach ($events as $event) 
					<li role="presentation" class="events" id="{{$event->id}}"><a href="#">
						<spam>{{$event->id}} - {{$event->name}}, {{$event->datetime}}</spam>
					</a></li>
				@endforeach
			</ul>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Patrons</div>
			<div class="panel-body">
				@foreach ($patronsInEvent as $patron) 
					<img src="{{$patron->picurl}}" alt="patronPic" height="42" width="42"> 
					<spam>{{$patron->name}} - {{$patron->address}}, {{$patron->suburb}}</spam></br>
				@endforeach
			</div>
		</div>
		<button type="button" class="btn btn-primary" id="load">Click ME!</button>
	</div>
	<div class="col-md-7">
		<div class="panel panel-default">
			<div class="panel-heading">Transport</div>
			<div class="panel-body" id="transportArrangments">
				
			</div>
		</div>
	</div>
</div>

<script>
$( document ).ready(function() {
	//Page load settings
	$('.events:first').addClass('active');
	var eventID = $('.events:first').attr('id');

	//=== Get eventID ===//
	$('.events').on('click', function() {
		$('.events').removeClass('active');
		$(this).addClass('active');
		eventID = $(this).attr('id');
	});
	//=== Run Ajax call to get patrons for the event ===//
	$('#load, .events').on('click', function() {
		$.get( "/getPatronsInEvent/"+eventID, function( data ) {
			console.log(data);// MOI use the DATA acquired here!!
            $('#transportArrangments').html('');
			$.each(data, function( index, value ) {//grabs each object in DATA
				$('#transportArrangments').append('<img src="' + value.picurl + '" alt="patronPic" height="42" width="42">' + 
                    ' ' + value.name + ' - ' + value.address + ', ' + value.suburb+ '</br>');
			});
			
		}, "json" );
	});
});


</script>

@endsection