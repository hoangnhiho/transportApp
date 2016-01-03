@extends('app')

@section('content')
<style>
    input[type='checkbox'] {
        width: 25px;
        height: 25px;
    }
</style>
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

        <a target="_blank" type="button" class="btn btn-primary" style="width: 100%" href='{{url("generateNearbySet/".$eventID)}}' >
            <spam class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></spam>
            Generate nearby sets
        </a>

	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div class="row" style="padding:0px 15px">
                Patrons
                <button type="button" class="btn btn-success btn-sm pull-right" id="refreshBtn" style="padding: 2px 5px 0px 5px;">
                    <spam class="glyphicon glyphicon-refresh" aria-hidden="true"></spam>
                </button>
                </div>
            </div>
			<div class="panel-body" id='patronList'>
                <div class="row">
                    <div class="col-md-1">
                        <!-- <input type="checkbox" id="checkAll">  -->
                    </div>
                    <div class="col-md-5"><b>Patron's details</b></div>
                    <div class="col-md-3"><b>Pref To</b></div>
                    <div class="col-md-3"><b>Pref Back</b></div>
                </div>
                <hr style="margin-top: 0px; margin-bottom: 10px;">
                @foreach ($patronsInEvent as $patron) 
                    <div class="row">
                        <div class="col-md-1">
                            <input type="checkbox" id="patron{{$patron->id}}" @if ($patron->softDelete =='1') checked @endif> 
                        </div>
                        <div class="col-md-1">
                            <img src="{{$patron->picurl}}" alt="patronPic" height="42" width="42"> 
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{url('patron/'.$patron->id)}}">{{$patron->name}}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="font-size: .8em;">{{$patron->address}}, {{$patron->suburb}}</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-control carthereOptions">
                                <option id="carthere{{$patron->id}}-none" @if($patron->carthere == 'none') selected @endif>none</option>
                                <option id="carthere{{$patron->id}}-any" @if($patron->carthere == 'any') selected @endif>any</option>
                                <option id="carthere{{$patron->id}}-driving" @if($patron->carthere == 'driving') selected @endif>driving</option>
                                @foreach ($patronsInEvent as $patron1) 
                                    @if ($patron1->carthere == 'driving' )
                                        <option id="carthere{{$patron->id}}-{{$patron1->id}}" @if($patron->carthere == $patron1->id) selected @endif>{{$patron1->name}}</option>
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
                                        <option id="carback{{$patron->id}}-{{$patron2->id}}" @if($patron->carback == $patron2->id) selected @endif>{{$patron2->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <p></p>
                @endforeach
			</div>
		</div>

        <button type="button" class="btn btn-primary" style="width: 100%" data-toggle="modal" data-target="#createPatronModal">
            <spam class="glyphicon glyphicon-plus" aria-hidden="true"></spam>
            Create new Patron
        </button><p></p>
		<button type="button" class="btn btn-primary" style="width: 100%" id="load">
            <spam class="glyphicon glyphicon-share" aria-hidden="true"></spam>
            Run Algorithm!
        </button>

    </div>

	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">Transport - There</div>
            <div class="panel-body">
                <div style="display:none">{{$counter = 1}}</div>
                @foreach ($patronsInEvent as $patron3) 
                    @if ($patron3->id % 5 == 1)
                    <div class="row" id="transportThere{{ceil ($patron3->id/5)}}">
                    <div class="col-md-3">
                        <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronThere{{$counter++}}">
                        <p id="textPatronThere{{$counter-1}}">{{$patron3->name}}</p>
                    </div>
                    @else
                    <div class="col-md-2">
                        <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronThere{{$counter++}}">
                        <p id="textPatronThere{{$counter-1}}">{{$patron3->name}}</p>
                    </div>
                    @endif
                    @if ($patron3->id % 5 == 0)
                        </div><!-- close row-->
                    @endif
                    @if ($patron3->id == count($patronsInEvent) && $patron3->id % 5 != 0)
                        </div></div>
                    @elseif ($patron3->id == count($patronsInEvent))
                        </div><!-- close body-->
                    @endif
                @endforeach
        
            </div><!-- close Panel-->
        </div><!-- close mod-md-3 -->

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">Transport - Back</div>
            <div class="panel-body">
                <div style="display:none">{{$counter = 1}}</div>
                @foreach ($patronsInEvent as $patron3) 
                    @if ($patron3->id % 5 == 1)
                    <div class="row" id="transportBack{{ceil ($patron3->id/5)}}">
                    <div class="col-md-3">
                        <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronBack{{$counter++}}">
                        <p id="textPatronBack{{$counter-1}}">{{$patron3->name}}</p>
                    </div>
                    @else
                    <div class="col-md-2">
                        <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronBack{{$counter++}}">
                        <p id="textPatronBack{{$counter-1}}">{{$patron3->name}}</p>
                    </div>
                    @endif
                    @if ($patron3->id % 5 == 0)
                        </div>
                    @endif
                    @if ($patron3->id == count($patronsInEvent) && $patron3->id % 5 != 0)
                        </div></div>
                    @elseif ($patron3->id == count($patronsInEvent))
                        </div><!-- close body-->
                    @endif
                @endforeach
            <div class="panel-footer" id="transportArrangments"></div>
        </div>
	</div>
</div>



@include('dev.createModal')

<script>
$( document ).ready(function() {
	//Page load settings
	var eventID = {!!$eventID!!};
    runAlgorithm();
    //=== Get eventID ===//
    $('#refreshBtn').on('click', function() {
        window.location.reload(1);
    });
	//=== Get eventID ===//
	$('.events').on('click', function() {
		$('.events').removeClass('active');
		$(this).addClass('active');
		eventID = $(this).attr('id');
	});

	//=== force run Algorithm ===//
	$('#load').on('click', function() {
		runAlgorithm();
	});

    //=== checkbox patron Ajax calls ===//
    $("input:checkbox").on('click', function(){
        var $this = $(this);
        var patronID = $this.attr("id").substring(6);
        if($this.is(":checked")){
            $.get( "/toggleEventPatron/"+eventID+"/"+patronID+"/"+"1", function( data ) {});
        }else{
            $('#carthere'+patronID+'-none').prop('selected', true);
            $('#carback'+patronID+'-none').prop('selected', true);
            $.get( "/toggleEventPatron/"+eventID+"/"+patronID+"/"+"0", function( data ) {});
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
// $.get( 'https://maps.googleapis.com/maps/api/distancematrix/jsonp?origins=Seattle&destinations=San+Francisco&key=AIzaSyCMZagc422ORCZhTfbFvMXDPUGxsFyGgD8',function(data){

//     console.log(data);
// });

    //=== run algorithm uses Ajax calls to retrive data===//
    function runAlgorithm() {
        $.get( "/getPatronsInEvent/"+eventID, function( data ) {
            $('#transportArrangments').html('');
            console.log(data);
            //==== Dynamically remake Transport Panel ===//
            // $.each(data, function( index, value ) {//grabs each object in DATA
            //     if (value.event_id && value.softDelete == "1"){
            //         $('#transportArrangments').append('<img src="' + value.picurl + '" alt="patronPic" height="42" width="42">' + 
            //             ' ' + value.name + ' - ' + value.address + ', ' + value.suburb + ', ' + value.carthere + ', ' + value.carback + '</br>');
            //     }else if(value.nearbyset){
            //         $('#transportArrangments').append(value.nearbyset + '</br>');
            //     }
            // });
        }, "json" );
    }

});

// setTimeout(function(){
//    window.location.reload(1);
// }, 120000);

</script>

@endsection