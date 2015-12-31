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
	<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">Patrons</div>
			<div class="panel-body" id='patronList'>
                @foreach ($patronsInEvent as $patron) 
                    <div class="row">
                        <div class="col-md-1">
                            <input type="checkbox" id="patron{{$patron->id}}" @if ($patron->softDelete =='1') checked @endif> 
                        </div>
                        <div class="col-md-5">
                            <img src="{{$patron->picurl}}" alt="patronPic" height="42" width="42"> 
                            <spam>{{$patron->name}} - {{$patron->address}}, {{$patron->suburb}}</spam>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control carthereOptions">
                                <option id="carthere{{$patron->id}}-none" @if($patron->carthere == 'none') selected @endif>none</option>
                                <option id="carthere{{$patron->id}}-any" @if($patron->carthere == 'any') selected @endif>any</option>
                                <option id="carthere{{$patron->id}}-driving" @if($patron->carthere == 'driving') selected @endif>driving</option>
                                @foreach ($patronsInEvent as $patron1) 
                                    @if ($patron1->carthere == 'driving' && $patron->carthere != $patron1->carthere)
                                        <option id="carthere{{$patron->id}}-{{$patron1->name}}" @if($patron->carthere == $patron1->name) selected @endif>{{$patron1->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control carbackOptions">
                                <option selected="selected" id="carback{{$patron->id}}-none" @if($patron->carback == 'none') selected @endif>none</option>
                                <option id="carback{{$patron->id}}-any" @if($patron->carback == 'any') selected @endif>any</option>
                                <option id="carback{{$patron->id}}-driving" @if($patron->carback == 'driving') selected @endif>driving</option>
                                @foreach ($patronsInEvent as $patron2) 
                                    @if ($patron2->carback == 'driving' && $patron->carback != $patron2->carback)
                                        <option id="carback{{$patron->id}}-{{$patron2->name}}" @if($patron->carback == $patron2->name) selected @endif>{{$patron2->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach
			</div>
		</div>
		<button type="button" class="btn btn-primary" id="load">Click ME!</button>
	</div>
	<div class="col-md-4">
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
	$('#load').on('click', function() {
		$.get( "/getPatronsInEvent/"+eventID, function( data ) {
            $('#transportArrangments').html('');
            //==== Dynamically remake Transport Panel ===//
			$.each(data, function( index, value ) {//grabs each object in DATA
                if (value.event_id && value.softDelete == "1"){
			        $('#transportArrangments').append('<img src="' + value.picurl + '" alt="patronPic" height="42" width="42">' + 
                        ' ' + value.name + ' - ' + value.address + ', ' + value.suburb + ', ' + value.carthere + ', ' + value.carback + '</br>');
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
            $('#carthere'+patronID+'-none').prop('selected', true);
            $('#carback'+patronID+'-none').prop('selected', true);
            $.get( "/toggleEventPatron/"+eventID+"/"+patronID+"/"+"0", function( data ) {
                //console.log(data);// MOI use the DATA acquired here!!
            });
        }
    });

    //=== CarThereOptions Ajax calls ===//
    $('.carthereOptions').on('change', function (e) {
        var tempVar = $(this).children(":selected").attr("id").substring(8).split('-');
        var patronId = tempVar[0];
        var driverId = tempVar[1];
        $.get( "/postCarThere/"+eventID+"/"+patronId+"/"+driverId, function( data ) {
            console.log(data);// MOI use the DATA acquired here!!
        });
    });

    //=== CarBackOptions Ajax calls ===//
    $('.carbackOptions').on('change', function (e) {
        var tempVar = $(this).children(":selected").attr("id").substring(7).split('-');
        var patronId = tempVar[0];
        var driverId = tempVar[1];
        $.get( "/postCarBack/"+eventID+"/"+patronId+"/"+driverId, function( data ) {
            console.log(data);// MOI use the DATA acquired here!!
        });
    });
});

</script>

@endsection