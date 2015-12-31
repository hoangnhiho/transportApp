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
					<li role="presentation" class="events @if ($eventID == $event->id) active @endif " id="{{$event->id}}"><a href="{{ url('/event/'.$event->id) }}">
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
			<div class="panel-body" id='patronList'>
                @foreach ($patronsInEvent as $patron) 
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="patron{{$patron->id}}" @if ($patron->softDelete =='1') checked @endif> 
                            <img src="{{$patron->picurl}}" alt="patronPic" height="42" width="42"> 
                            <spam>{{$patron->name}} - {{$patron->address}}, {{$patron->suburb}}</spam></br>
                        </label>
                    </div>
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
	var eventID = {!!$eventID!!};

	//=== Get eventID ===//
	$('.events').on('click', function() {
		$('.events').removeClass('active');
		$(this).addClass('active');
		eventID = $(this).attr('id');
	});

	//=== Run Ajax call to get patrons for the event ===//
	$('#load, window').on('click', function() {
		$.get( "/getPatronsInEvent/"+eventID, function( data ) {
            $('#transportArrangments').html('');
            //==== Dynamically remake Transport Panel ===//
			$.each(data, function( index, value ) {//grabs each object in DATA
                if (value.event_id && value.softDelete == "1"){
			        $('#transportArrangments').append('<img src="' + value.picurl + '" alt="patronPic" height="42" width="42">' + 
                        ' ' + value.name + ' - ' + value.address + ', ' + value.suburb+ '</br>');
                }else if(value.nearbyset){
                    $('#transportArrangments').append(value.nearbyset + '</br>');
                }
			});
		}, "json" );
	});

    //=== checkbox patron Ajax calls ===//
    $("input:checkbox").on('click', function(){
        var $this = $(this);
        var patronID = $this.attr("id").substring(6);
        if($this.is(":checked")){
            $.get( "/toggleEventPatron/"+eventID+"/"+patronID+"/"+"1", function( data ) {
                //console.log(data);// MOI use the DATA acquired here!!
            });
        }else{
            $.get( "/toggleEventPatron/"+eventID+"/"+patronID+"/"+"0", function( data ) {
                //console.log(data);// MOI use the DATA acquired here!!
            });
        }
    });
});

</script>

@endsection