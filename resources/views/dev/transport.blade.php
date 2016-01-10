@extends('app')

@section('content')
<style>
    input[type='checkbox'] {
        width: 25px;
        height: 25px;
    }
    @media (max-width : 430px) {
        input[type='checkbox'] {
            width: 45px;
            height: 45px;
        }
        .patronDetailRow{
            min-height: 55px;
        }
        .panel-body{
            padding-left:23px;
            padding-right:23px;
        }
        .displayPic{
            max-width: 60px;
        }
    }
</style>
<div class='row'>
    <div class="col-md-3 dummyColumn" style="display:none"></div>
	<div class="col-md-2 eventColumn">
		<div class="panel panel-default">
			<div class="panel-heading">Events</div>
			<div class="panel-body">
			<ul class="nav nav-pills nav-stacked">
				@foreach ($events as $event) 
					<li role="presentation" class="events @if ($eventID == $event->id) active @endif " id="{{$event->id}}"><a href="{{ url('/eventAdmin/'.$event->id) }}">
						<spam>{{$event->id}} - {{$event->name}}, {{$event->datetime}}</spam>
					</a></li>
				@endforeach
			</ul>
			</div>
		</div>

        <a target="_blank" type="button" class="btn btn-primary" style="width: 100%" href='{{url("generateNearbySet")}}' >
            <spam class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></spam>
            Generate nearby sets
        </a>

	</div>
	<div class="col-md-4 patronColumn">
		<div class="panel panel-default">
			<div class="panel-heading">
                <div class="row" style="padding:0px 15px">
                <a data-toggle="collapse" href="#patronList">Patrons</a>
                <button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#createPatronModal" style="padding: 2px 5px 0px 5px; margin-left:3px;">
                    <spam class="glyphicon glyphicon-plus" aria-hidden="true"></spam>
                </button>
                <button type="button" class="btn btn-success btn-sm pull-right" id="refreshBtn" style="padding: 2px 5px 0px 5px; margin-left:3px;">
                    <spam class="glyphicon glyphicon-refresh" aria-hidden="true"></spam>
                </button>
                </div>
            </div>
			<div class="panel-body collapse in" id='patronList'>
                <div class="row">
                    <div class="col-md-1">
                        <!-- <input type="checkbox" id="checkAll">  -->
                    </div>
                    <div class="col-xs-12 col-md-5"><b>Patron's details</b></div>
                    <div class="col-xs-6 col-md-3"><b>Pref To</b></div>
                    <div class="col-xs-6 col-md-3"><b>Pref Back</b></div>
                </div>
                <hr style="margin-top: 0px; margin-bottom: 10px;">
                @foreach ($patronsInEvent as $patron) 
                    <div class="row">
                        <div class="col-xs-2 col-md-1">
                            <input type="checkbox" id="patron{{$patron->id}}" @if ($patron->softDelete =='1') checked @endif> 
                        </div>
                        <div class="col-xs-2 col-md-1 displayPic">
                            <img src="{{$patron->picurl}}" alt="patronPic" class="img-thumbnail" style="width: 100%"> 
                        </div>
                        <div class="col-xs-8 col-md-4 patronDetailRow">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{url('patron/'.$patron->id)}}">{{ucwords($patron->name)}}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="font-size: .8em;">{{$patron->address}}, {{ucfirst($patron->suburb)}}</div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <select class="form-control carthereOptions">
                                <option id="carthere{{$patron->id}}-none" @if($patron->carthere == 'none') selected @endif>none</option>
                                <option id="carthere{{$patron->id}}-any" @if($patron->carthere == 'any') selected @endif>any</option>
                                <option id="carthere{{$patron->id}}-driving" @if($patron->carthere == 'driving') selected @endif>driving</option>
                                @foreach ($patronsInEvent as $patron1) 
                                    @if ($patron1->carthere == 'driving' )
                                        <option id="carthere{{$patron->id}}-{{$patron1->id}}" @if($patron->carthere == $patron1->id) selected @endif>{{$patron1->name}}</option>
                                    @elseif ($patron1->carthere != 'driving' && $patron->carthere != 'none' && $patron->carthere != 'any' && $patron->carthere != 'driving' && $patron->carthere == $patron1->id)
                                        <option id="carthere{{$patron->id}}-{{$patron1->id}}" @if($patron->carthere == $patron1->id) selected @endif>{{$patron1->name}}</option>
                                    @endif
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="col-xs-6 col-md-3">
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

		<button type="button" class="btn btn-primary" style="width: 100%;display:none;" id="load">
            <spam class="glyphicon glyphicon-share" aria-hidden="true"></spam>
            Run Algorithm!
        </button>

    </div>

	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading"><a data-toggle="collapse" href="#transportThereList">Transport - There</a></div>
            <div class="panel-body collapse in" id="transportThereList">
                <div style="display:none">{{$counter = 1}}</div>
                @foreach ($patronsInEvent as $patron3) 
                    @if ($patron3->id % 5 == 1)
                    <div class="row" id="transportThere{{ceil ($patron3->id/5)}}">
                    <div class="col-xs-3 col-md-3">
                        <a data-toggle="modal" id="modalPatronThere{{$counter}}" href="{{url('getModalPatron/1')}}" data-target="#patronModal"><img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronThere{{$counter++}}" style="display: none"></a>
                        <p id="textPatronThere{{$counter-1}}" style="display: none">{{$patron3->name}}</p>
                    </div>
                    @else
                    <div class="col-xs-2 col-md-2">
                        <a data-toggle="modal" id="modalPatronThere{{$counter}}" href="{{url('getModalPatron/1')}}" data-target="#patronModal"><img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronThere{{$counter++}}" style="display: none"></a>
                        <p id="textPatronThere{{$counter-1}}" style="display: none; height:28px;">{{$patron3->name}}</p>
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
            <div class="panel panel-default">
                <div class="panel-heading"><a data-toggle="collapse" href="#walkingThereList">Walkers - There</a></div>
                <div class="panel-body collapse in" id="walkingThereList">
                    <div class="row">
                    <div style="display:none">{{$counter = 1}}</div>
                        @foreach ($patronsInEvent as $patron3)
                            <div class="col-xs-2 col-md-2">
                                <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgWalkingThere{{$counter++}}" style="display: none">
                                <p id="textWalkingThere{{$counter-1}}" style="display: none; height:28px;">{{$patron3->name}}</p>
                            </div>
                        @endforeach
                    </div> 
                </div>
            </div>
        </div><!-- close mod-md-3 -->

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><a data-toggle="collapse" href="#transportBackList">Transport - Back</a></div>
            <div class="panel-body collapse in" id="transportBackList">
                <div style="display:none">{{$counter = 1}}</div>
                @foreach ($patronsInEvent as $patron3) 
                    @if ($patron3->id % 5 == 1)
                    <div class="row" id="transportBack{{ceil ($patron3->id/5)}}">
                    <div class="col-xs-3 col-md-3">
                        <a data-toggle="modal" id="modalPatronBack{{$counter}}" href="{{url('getModalPatron/1')}}" data-target="#patronModal"><img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronBack{{$counter++}}" style="display: none"></a>
                        <p id="textPatronBack{{$counter-1}}" style="display: none">{{$patron3->name}}</p>
                    </div>
                    @else
                    <div class="col-xs-2 col-md-2">
                        <a data-toggle="modal" id="modalPatronBack{{$counter}}" href="{{url('getModalPatron/1')}}" data-target="#patronModal"><img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronBack{{$counter++}}" style="display: none"></a>
                        <p id="textPatronBack{{$counter-1}}" style="display: none; height:28px;">{{$patron3->name}}</p>
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
        </div>
            <div class="panel panel-default">
                <div class="panel-heading"><a data-toggle="collapse" href="#walkingBackList">Walkers - Back</a></div>
                <div class="panel-body collapse in" id="walkingBackList">
                    <div class="row">
                    <div style="display:none">{{$counter = 1}}</div>
                        @foreach ($patronsInEvent as $patron3)
                            <div class="col-xs-2 col-md-2">
                                <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgWalkingBack{{$counter++}}" style="display: none">
                                <p id="textWalkingBack{{$counter-1}}" style="display: none; height:28px;">{{$patron3->name}}</p>
                            </div>
                        @endforeach
                    </div> 
                </div>
            </div>
	</div>
</div>



@include('dev.createModal')

<script>
var arrayPatron = [];
var arrayNearBySet = [];
//SL, TW, TR, AU, IN
//CA, KA, WA, OA, SA
suburbs = {
    SLSL:1, SLTW:2, SLTR:2, SLAU:3, SLIN:3, SLCA:4, SLKA:5, SLWA:6, SLOA:6, SLSA:7,
    TWSL:2, TWTW:1, TWTR:2, TWAU:2, TWIN:3, TWCA:4, TWKA:4, TWWA:5, TWOA:6, TWSA:6, 
    TRSL:2, TRTW:2, TRTR:1, TRAU:3, TRIN:2, TRCA:3, TRKA:5, TRWA:6, TROA:5, TRSA:7,
    AUSL:3, AUTW:2, AUTR:2, AUAU:1, AUIN:4, AUCA:5, AUKA:3, AUWA:4, AUOA:7, AUSA:5,
    INSL:3, INTW:3, INTR:2, INAU:4, ININ:1, INCA:2, INKA:6, INWA:7, INOA:4, INSA:6, 
    CASL:4, CATW:4, CATR:3, CAAU:5, CAIN:2, CACA:1, CAKA:7, CAWA:8, CAOA:4, CASA:9, 
    KASL:5, KATW:5, KATR:5, KAAU:3, KAIN:6, KACA:7, KAKA:1, KAWA:3, KAOA:7, KASA:5, 
    WASL:6, WATW:5, WATR:6, WAAU:4, WAIN:7, WACA:8, WAKA:3, WAWA:1, WAOA:8, WASA:3, 
    OASL:6, OATW:6, OATR:5, OAAU:7, OAIN:4, OACA:4, OAKA:7, OAWA:8, OAOA:1, OASA:4, 
    SASL:7, SATW:6, SATR:7, SAAU:5, SAIN:6, SACA:9, SAKA:5, SAWA:3, SAOA:4, SASA:1 
};
$( document ).ready(function() {
	//Page load settings
    var URL = window.location.origin;
	var eventID = {!!$eventID!!};
    @if (isset($publicShow))
        $('.eventColumn').hide();
        $('.patronColumn').hide();
        $('.dummyColumn').show();
    @endif
    
    //Collapses all panels if mobile.
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
          $('#patronList').collapse('hide');
          //$('#transportThereList').collapse('hide');
          $('#walkingThereList').collapse('hide');
          //$('#transportBackList').collapse('hide');
          $('#walkingBackList').collapse('hide');
    }

    runAlgorithm();
    $('body').on('hidden.bs.modal', '.modal', function () {
        $(this).removeData('bs.modal');
    });
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
            $('#carthere'+patronID+'-any').prop('selected', true);
            $('#carback'+patronID+'-any').prop('selected', true);
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
        if (driverId != "none") $('#patron'+patronId).prop( "checked", true );
        $.get( "/postCarThere/"+eventID+"/"+patronId+"/"+driverId, function( data ) {
            //console.log(data);
        });
    });

    //=== CarBackOptions Ajax calls ===//
    $('.carbackOptions').on('change', function (e) {
        var tempVar = $(this).children(":selected").attr("id").substring(7).split('-');
        var patronId = tempVar[0];
        var driverId = tempVar[1];
        if (driverId != "none") $('#patron'+patronId).prop( "checked", true );
        $.get( "/postCarBack/"+eventID+"/"+patronId+"/"+driverId, function( data ) {
            //console.log(data);
        });
    });

    //=== run algorithm uses Ajax calls to retrive data===//
    function runAlgorithm() {
        arrayPatron = []
        arrayNearBySet = []
        var max = 0;
        $.get( "/getPatronsInEvent/"+eventID, function( data ) {
            $('#transportArrangments').html('');
            //==== Dynamically remake Transport Panel ===//
            $.each(data, function( index, value ) {//grabs each object in DATA
                max++;
                if (value.event_id && value.softDelete == "1"){
                    arrayPatron.push(value);
                }else if(value.nearbyset){
                    arrayNearBySet.push(JSON.parse("[" + value.nearbyset + "]"));
                }
            });
            for (var i = 0; i<=max;i++){
                $('#imgPatronThere'+i).hide();
                $('#textPatronThere'+i).hide();
                $('#imgPatronBack'+i).hide();
                $('#textPatronBack'+i).hide();

                $('#imgWalkingThere'+i).hide();
                $('#textWalkingThere'+i).hide();
                $('#imgWalkingBack'+i).hide();
                $('#textWalkingBack'+i).hide();
            }
            //console.log(JSON.stringify(arrayPatron));
            //console.log(JSON.stringify(arrayNearBySet));

            var plan = runTransportAlgorithm(arrayPatron, arrayNearBySet);
            var planThere = plan[0];
            var planBack = plan[1];
            var walkThere = plan[2];
            var walkBack = plan[3];

            console.log(plan);
            //console.log(walkThere);
            //console.log(planBack);

            var counter = 1;
            planThere.forEach(function(car) {
                car.forEach(function(passenger){
                    $('#imgPatronThere'+counter).show();
                    $('#textPatronThere'+counter).show();
                    $('#imgPatronThere'+counter).attr('src', passenger.picurl);
                    $('#modalPatronThere'+counter).attr('href', URL+'/getModalPatron/'+passenger.id);
                    $('#textPatronThere'+counter).html(passenger.name);
                    counter++;
                });
                if (counter%5 != 1){
                    counter = ((Math.ceil(counter/5))*5)+1;
                }
            });

            var counter = 1;
            walkThere.forEach(function(walker) {
                $('#imgWalkingThere'+counter).show();
                $('#textWalkingThere'+counter).show();
                $('#imgWalkingThere'+counter).attr('src', walker.picurl);
                $('#textWalkingThere'+counter).html(walker.name);
                counter++;
            });

            counter=1;
            planBack.forEach(function(car) {
                car.forEach(function(passenger){
                    $('#imgPatronBack'+counter).show();
                    $('#textPatronBack'+counter).show();
                    $('#imgPatronBack'+counter).attr('src', passenger.picurl);
                    $('#modalPatronBack'+counter).attr('href', URL+'/getModalPatron/'+passenger.id);
                    $('#textPatronBack'+counter).html(passenger.name);
                    counter++;
                });
                if (counter%5 != 1){
                    counter = ((Math.ceil(counter/5))*5)+1;
                }
            });
            
            var counter = 1;
            walkBack.forEach(function(walker) {
                $('#imgWalkingBack'+counter).show();
                $('#textWalkingBack'+counter).show();
                $('#imgWalkingBack'+counter).attr('src', walker.picurl);
                $('#textWalkingBack'+counter).html(walker.name);
                counter++;
            });

        }, "json" );
    }



});


/* Main function for processing the transport plans accepts a group of 
   patrons and returns an array of cars */
function runTransportAlgorithm(patrons, nearbySetsList){
    var driversThere = new Array();
    var driversBack = new Array();
    var passengersThere = new Array();
    var passengersBack = new Array();

    var carsThere = new Array();
    var carsBack = new Array();
    var walkingThere = new Array();
    var walkingBack = new Array();

    processSuburbMappings(patrons);

    console.log(patrons);

    for(var i = 0; i < patrons.length; i++){
        if(patrons[i].carthere == "driving"){
            driversThere.push(patrons[i]);
        } else {
            if(patrons[i].carthere != "none" && patrons[i].carthere != "staying"){
                passengersThere.push(patrons[i]); 
            }
            
        }
        if(patrons[i].carback == "driving"){
            driversBack.push(patrons[i]);
        } else {
            if(patrons[i].carback != "none" && patrons[i].carback != "staying"){
                passengersBack.push(patrons[i]);
            }
        }
    }

    /* Place the drivers in their cars. The cars are arrays with the driver in the 
    first position */ 
    for(var i = 0; i < driversThere.length; i++){
        carsThere.push(new Array(driversThere[i]));
    }
    for(var i = 0; i < driversBack.length; i++){
        carsBack.push(new Array(driversBack[i]));
    }

    /* Process preferences */
    /*for(var i = 0; i < passengersThere.length; i++){
        if(passengersThere[i].carthere == "none" || passengersThere[i].carthere == "staying"){
            passengersThere.splice(i, 1);
        }
    }

    for(var i = 0; i < passengersBack.length; i++){
        if(passengersBack[i].carback == "none" || passengersBack[i].carback == "staying"){
            passengersBack.splice(i, 1);
        }
    }*/

    for(var i = 0; i < passengersThere.length; i++){
        if(passengersThere[i].carthere != "none" && passengersThere[i].carthere != "driving" &&
            passengersThere[i].carthere != "staying"  && passengersThere[i].carthere != "any"){
            if(driverIDIndexInCarList(carsThere, passengersThere[i].carthere) != -1){
                if(carsThere[driverIDIndexInCarList(carsThere, passengersThere[i].carthere)].length < 5){
                    carsThere[driverIDIndexInCarList(carsThere, passengersThere[i].carthere)].push(passengersThere[i]);
                }
            }
        }
    }

    removeProcessedPassengers(passengersThere, carsThere);

    for(var i = 0; i < passengersBack.length; i++){
        if(passengersBack[i].carback != "none" && passengersBack[i].carback != "driving" &&
            passengersBack[i].carback != "staying"  && passengersBack[i].carback != "any"){
            if(driverIDIndexInCarList(carsBack, passengersBack[i].carback) != -1){
                if(carsBack[driverIDIndexInCarList(carsBack, passengersBack[i].carback)].length < 5){
                    carsBack[driverIDIndexInCarList(carsBack, passengersBack[i].carback)].push(passengersBack[i]);
                }
            }
        }
    }

    removeProcessedPassengers(passengersBack, carsBack);

    if(carsThere.length != 0){
        processPlan(patrons, carsThere, walkingThere, passengersThere, nearbySetsList, "there");
    }

    if(carsBack.length != 0){
        processPlan(patrons, carsBack, walkingBack, passengersBack, nearbySetsList, "back");
    }

    return new Array(carsThere, carsBack, walkingThere, walkingBack);
}



function processPlan(patronsList, carsList, walkingList, passengersList, nearbySetsList, direction){
    /* Remove the nearby sets that are not relevant to the current transport plan 
    this means that there are not at least two patrons of the nearby set that are attending the event. */
    var tempPassengersList = new Array();
    for(var i = 0; i < passengersList.length; i++){
        tempPassengersList.push(passengersList[i])
    }

    for(var i = 0; i < carsList.length; i++){
        for(var j = 0; j < carsList[i].length; j++){
            tempPassengersList.push(carsList[i][j]);
        }
    }

    var relevantNearbySets = 
        processNearbySetsFromPassengerList(nearbySetsList, tempPassengersList);

    /* Sort relevantNearbySets by length */
    //var b = list[y];
    //list[y] = list[x];
    //list[x] = b;
    for(var k = 0; k < 5; k++){
        for(var i = 0; i < relevantNearbySets.length; i++){
            if(!(i+1 >= relevantNearbySets.length)){
                if(relevantNearbySets[i].length < relevantNearbySets[i+1].length){
                    var tempNBSet = relevantNearbySets[i];
                    relevantNearbySets[i] = relevantNearbySets[i+1];
                    relevantNearbySets[i+1] = tempNBSet;
                }
            } 
        }
    }

    /* Process the nearby sets into their cars */

    /* Process nearby sets with three passengers */
    for(var i = 0; i < relevantNearbySets.length; i++){
        if(relevantNearbySets[i].length == 3){
            /* Find a car that has two people in it if the driver or the first passenger share the same suburb as the nearby set then add the nearby set to this car */
            var tempBestCarIndex = "false";
            for(var j = 0; j < carsList.length; j++){
                /*if(carsList[j].length == 1){
                    if(carsList[j][0].suburb == relevantNearbySets[i][0].suburb){
                        tempBestCarIndex = j;
                    } 
                }*/
                if(carsList[j].length == 2){
                    /* If the suburb of either the driver or the first passenger is the same as the nearby set of three */
                    if(carsList[j][1].suburb == relevantNearbySets[i][0].suburb || carsList[j][0].suburb == relevantNearbySets[i][0].suburb){
                        tempBestCarIndex = j;
                    }
                    /* If the suburb of both the driver or the first passenger is the same as the nearby set of three, then push immediately */
                    if(carsList[j][i].suburb == relevantNearbySets[i][0].suburb && carsList[j][0].suburb == relevantNearbySets[i][0].suburb){
                        tempBestCarIndex = j;
                        //addToPlan(carsList, walkingList, relevantNearbySets[i][j], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
                        break;
                    }
                }
            }

            /* If there is no car that has the driver or first passenger suburb the same as the suburb for the nearby set of three, then if there is no other
            passenger of the same suburb as the nearby set then add the nearby set to a car with only three spaces. Otherwise leave it how it is (tempBestCarIndex = false)
            and the nearby set of three will be placed in an empty car (a car with four spaces). */
            if(tempBestCarIndex == "false"){
                for(var k = 0; k < passengersList.length; k++){
                    if(passengersList[k].suburb == relevantNearbySets[i][0].suburb
                        && passengersList[k].patron_id != relevantNearbySets[i][0].patron_id
                        && passengersList[k].patron_id != relevantNearbySets[i][1].patron_id
                        && passengersList[k].patron_id != relevantNearbySets[i][2].patron_id){
                        tempBestCarIndex = "place in empty car";
                        
                    }
                }
            }

            if(tempBestCarIndex != "place in empty car"){
                for(var m = 0; m < carsList.length; m++){
                    if(carsList[m].length == 2){
                        tempBestCarIndex = m;
                        break;
                    }
                }
            }

            if(tempBestCarIndex == "place in empty car"){
                tempBestCarIndex = "false";
            }

            if(tempBestCarIndex != "false"){
                for(var k = 0; k < relevantNearbySets[i].length; k++){
                    addToPlan(carsList, walkingList, relevantNearbySets[i][k], tempBestCarIndex, direction);
                }
            }
        }
    }

    /* Process nearby set where one of the passengers of the nearby set were processed as a preference */
    for(var i = 0; i < relevantNearbySets.length; i++){
        for(var j = 0; j < relevantNearbySets[i].length; j++){    
            if(carIndexOfPassenger(carsList, walkingList, relevantNearbySets[i][j]) != -1){
                for(var k = 0; k < relevantNearbySets[i].length; k++){
                    addToPlan(carsList, walkingList, relevantNearbySets[i][k], carIndexOfPassenger(carsList, walkingList, relevantNearbySets[i][j]), direction);
                }
            }        
        }
    }

    /* Process the rest of the nearby sets by the closest driver to the nearby set */
    for(var i = 0; i < relevantNearbySets.length; i++){
        var bestDriver = calculateBestDriver(carsList, relevantNearbySets[i][0], relevantNearbySets[i].length);
        for(var j = 0; j < relevantNearbySets[i].length; j++){
            if(!isDriver(carsList, relevantNearbySets[i][j])){
                addToPlan(carsList, walkingList, relevantNearbySets[i][j], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
            }
        }   
    }

    removeProcessedPassengers(passengersList, carsList);

    /* Separate passengers into new arrays */
    suburbSeparatedPassengersList = new Array();
    for(var i = 0; i < passengersList.length; i++){
        var processed = false;
        for(var j = 0; j < suburbSeparatedPassengersList.length; j++){
            if(suburbSeparatedPassengersList.length > 0){
                if(suburbSeparatedPassengersList[j][0].suburb == passengersList[i].suburb){
                    suburbSeparatedPassengersList[j].push(passengersList[i]);
                    processed = true;
                }   
            } else {
                suburbSeparatedPassengersList.push(new Array(passengersList[i]));
            }
        }
        if(!processed){
            suburbSeparatedPassengersList.push(new Array(passengersList[i]));
        }
    }

    removeProcessedPassengers(passengersList, carsList);

    /*Process passengers who share a suburb with one of the suburbs that the driver is already intending to visit*/
    for(var i = 0; i < passengersList.length; i++){
        for(var j = 0; j < carsList.length; j++){
            for(var k = 0; k < carsList[j].length; k++){
                if(passengersList[i].suburb == carsList[j][k].suburb){
                    addToPlan(carsList, walkingList, passengersList[i], j, direction);
                }
            }
        }
    }

    /* Process passengers which share the same suburb as a driver */
    for(var i = 0; i < suburbSeparatedPassengersList.length; i++){
        for(var j = 0; j < suburbSeparatedPassengersList[i].length; j++){
            for(var k = 0; k < carsList.length; k++){
                var thisthing = suburbs[String(suburbSeparatedPassengersList[i][j].suburb).concat(carsList[k][0].suburb)];
                var sub1 = suburbSeparatedPassengersList[i][j].suburb;
                var sub2 = carsList[k][0].suburb;
                if(suburbs[String(suburbSeparatedPassengersList[i][j].suburb).concat(carsList[k][0].suburb)] == 1){
                    if(carsList[k].length < 5){
                        addToPlan(carsList, walkingList, suburbSeparatedPassengersList[i][j], k, direction);
                        break;
                    }
                }
            }   
        }
    }

    removeProcessedPassengers(passengersList, carsList);
    /* Process the remaining passengers into their cars */
    /*for(var i = 0; i < passengersList.length; i++){
        var bestDriver = calculateBestDriver(carsList, passengersList[i], 1);
        addToPlan(carsList, walkingList, passengersList[i], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
    }*/
    /*for(var currentDistantRank = 0; currentDistantRank < 9; currentDistantRank++){
        for(var i = 0; i < passengersList.length; i++){
            var bestDriver = calculateBestDriver(carsList, passengersList[i], 1);
            addToPlan(carsList, walkingList, passengersList[i], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
        }
    }*/



    for(var currentDistantRank = 0; currentDistantRank < 12; currentDistantRank++){
        for(var i = 0; i < passengersList.length; i++){
            var bestDriver = calculateBestDriver(carsList, passengersList[i], 1);
            var thisss = suburbs[String(bestDriver.suburb).concat(passengersList[i].suburb)];
            var thisscode = String(bestDriver.suburb).concat(passengersList[i].suburb);
            var passenger_name = passengersList[i].name;
            var best_drivername = bestDriver.name;
            if(suburbs[String(bestDriver.suburb).concat(passengersList[i].suburb)] == currentDistantRank){
                /*if(numOfSeatsRemaining(carsList) > (5-carsList[driverIDIndexInCarList(carsList, bestDriver.patron_id)].length)){
                    //SL, TW, TR, AU, IN
                    //CA, KA, WA, OA, SA
                    if(passengersList[i].suburb == "SL" || passengersList[i].suburb == "TW" || passengersList[i].suburb == "TR" || passengersList[i].suburb == "AU" || passengersList[i].suburb == "IN"){
                        if(carsList[driverIDIndexInCarList(carsList, bestDriver.patron_id)][1] != undefined){
                            if(carsList[driverIDIndexInCarList(carsList, bestDriver.patron_id)][1].suburb != "CA" &&
                                carsList[driverIDIndexInCarList(carsList, bestDriver.patron_id)][1].suburb != "KA" &&
                                carsList[driverIDIndexInCarList(carsList, bestDriver.patron_id)][1].suburb != "WA" &&
                                carsList[driverIDIndexInCarList(carsList, bestDriver.patron_id)][1].suburb != "OA" &&
                                carsList[driverIDIndexInCarList(carsList, bestDriver.patron_id)][1].suburb != "SA"){
                                addToPlan(carsList, walkingList, passengersList[i], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
                            }
                        }
                    } else {
                        addToPlan(carsList, walkingList, passengersList[i], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
                    }
                } else {
                    addToPlan(carsList, walkingList, passengersList[i], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
                }*/
                addToPlan(carsList, walkingList, passengersList[i], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
            }
        }
    }

    removeProcessedPassengers(passengersList, carsList);

    for(var i = 0; i < passengersList.length; i++){
        var bestDriver = calculateBestDriver(carsList, passengersList[i], 1);
        addToPlan(carsList, walkingList, passengersList[i], driverIDIndexInCarList(carsList, bestDriver.patron_id), direction);
    }

    removeProcessedPassengers(passengersList, carsList);
}

function visitingSuburbs(car){
    var suburbVisits = new Array();
    for(var i = 0; i < car.length; i++){
        suburbVisits.push(car[i].suburb);
    }
    return suburbVisits;
}

/* Takes a set of cars and a passenger, returns the best driver for the 
passenger. If the most efficient driver has a full car, then the next most efficient 
driver that does not have a full car is the best driver. */
function calculateBestDriver(cars, patron, numPatrons){
    var i = 0;
    var bestDriver = cars[i][0];
    var currentSuburbPairRank = suburbs[String(patron.suburb).concat(cars[i][0].suburb)];
    var bestCarIndex = 0;
    var carSummations = new Array();
    while(cars[i].length > 4 - (numPatrons - 1)){
        i++;
        if(i >= cars.length){
            return -1;
        }
        bestDriver = cars[i][0];
        bestCarIndex = i;
        currentSuburbPairRank = suburbs[String(patron.suburb).concat(cars[i][0].suburb)];
    }
    for(; i < cars.length; i++){
        if(suburbs[String(patron.suburb).concat(cars[i][0].suburb)] < currentSuburbPairRank
            && cars[i].length < 5 - (numPatrons - 1)){
            currentSuburbPairRank = suburbs[String(patron.suburb).concat(cars[i][0].suburb)];
            bestDriver = cars[i][0];
            bestCarIndex = i;
        }
    }
    /*for(; i < cars.length; i++){
        var tempSum = 0;
        for(var j = 0; j < cars[i].length; j++){
            tempSum = tempSum + 
        }
    }*/
    /* Make the best driver the driver with the least passenger */
    if(bestDriver.suburb != patron.suburb){
        for(var i = 0; i < cars.length; i++){
            if(cars[bestCarIndex].length > cars[i].length &&
                cars[bestCarIndex].suburb == cars[i].suburb){
                bestDriver = cars[i][0];
                bestCarIndex = i;
            }
        }
    }
    return bestDriver;
}

function isDriver(cars, patron){
    for(var i = 0; i < cars.length; i++){
        if(cars[i][0].patron_id == patron.patron_id){
            return true;
        }
    }
    return false;
}

function seatsRemaining(cars){
    var sumOfSeats = 0;
    for(var i = 0; i < cars.length; i++){
        sumOfSeats = sumOfSeats + cars[i].length;
    }
    if(sumOfSeats >= (cars.length * 5)){
        return false;
    }
    return true;
}

function numOfSeatsRemaining(cars){
    var sumOfSeats = 0;
    for(var i = 0; i < cars.length; i++){
        sumOfSeats = sumOfSeats + cars[i].length;
    }
    return (cars.length * 5) - sumOfSeats;
}

function addToPlan(cars, walking, passenger, carIndex, direction){
    if(seatsRemaining(cars)){
        if(carIndex != -1 && cars[carIndex].length != 5){
            if(!planContains(cars, walking, passenger)){
                if((direction == "there" && passenger.carthere != "none")
                    || (direction == "back" && passenger.carback != "none")){
                    cars[carIndex].push(passenger); 
                }
            }
            return false;
        }
    } else {
        if(!planContains(cars, walking, passenger)){
            if((direction == "there" && passenger.carthere != "none")
                || (direction == "back" && passenger.carback != "none")){
                walking.push(passenger);
            }
        }
        return false;
        //walking.push(passenger);
    }
}

function planContains(cars, walking, passenger){
    for(var i = 0; i < cars.length; i++){
        for(var j = 0; j < cars[i].length; j++){
            if(cars[i][j].patron_id == passenger.patron_id){
                return true;
            }
        }
    }
    for(var i = 0; i < walking.length; i++){
        if(walking[i].patron_id == passenger.patron_id){
            return true;
        }
    }
    return false;
}

function carIndexOfPassenger(cars, walking, passenger){
    for(var i = 0; i < cars.length; i++){
        for(var j = 0; j < cars[i].length; j++){
            if(cars[i][j].patron_id == passenger.patron_id){
                return i;
            }
        }
    }
    for(var i = 0; i < walking.length; i++){
        if(walking[i].patron_id == passenger.patron_id){
            return -1;
        }
    }
    return -1;
}

function removeProcessedPassengers(passengersList, carsList){
    for(var i = 0; i < carsList.length; i++){
        for(var j = 0; j < carsList[i].length; j++){
            for(var k = 0; k < passengersList.length; k++){
                if(carsList[i][j].patron_id == passengersList[k].patron_id){
                    passengersList.splice(k, 1);
                }
            }
        }
    }
}

function processNearbySetsFromPassengerList(nearbySetsList, passengersList){
    relevantNearbySetsList = new Array();
    for(var i = 0; i < nearbySetsList.length; i++){
        var tempNearbySet = new Array();
        for(var j = 0; j < nearbySetsList[i].length; j++){
            for(var k = 0; k < passengersList.length; k++){
                if(nearbySetsList[i][j] == passengersList[k].patron_id){
                    tempNearbySet.push(nearbySetsList[i][j]);
                }
            }   
        }
        if(tempNearbySet.length > 1){
            relevantNearbySetsList.push(tempNearbySet);
        }
    }

    transformedNearbySetsList = new Array();
    for(var i = 0; i < relevantNearbySetsList.length; i++){
        var tempNearbySet = new Array();
        for(var j = 0; j < relevantNearbySetsList[i].length; j++){
            tempNearbySet.push(
                matchPatronIDToPatronFromList(passengersList, relevantNearbySetsList[i][j]));
        }
        transformedNearbySetsList.push(tempNearbySet);
    }
    return transformedNearbySetsList;
}

/*Give a list of patrons and a patron ID then return the patron which from
the patron list which matches the patron ID.*/
function matchPatronIDToPatronFromList(patronList, patronId){
    for(var i = 0; i < patronList.length; i++){
        if(patronList[i].patron_id == patronId){
            return patronList[i];
        }
    }

}

function getPatronIndexFromPatronList(patronsList, patronId){
    contains = false;
    for(var k = 0; k < patronsList.length; k++){
        if(patronsList[k].patron_id == patronId){
            return k;
        }
    }
    return -1;
}

function patronsListContainsPatronID(patronsList, patronId){
    contains = false;
    for(var k = 0; k < patronsList.length; k++){
        if(patronsList[k].patron_id == patronId){
            contains = true;
        }
    }
    return contains;
}

/* returns the index of a driver from a list of cars */
function driverIDIndexInCarList(cars, driverId){
    for(var i = 0; i < cars.length; i++){
        if(cars[i][0].patron_id == driverId){
            return i;
        }
    }
    return -1;
}



/* takes a patron and modifies the suburb field so that is useable by
the algorithm */
function processSuburbMappings(patrons){
    for(var i = 0; i < patrons.length; i++){
        if(patrons[i].suburb == "stlucia"){
            patrons[i].suburb = "SL";
        } else if(patrons[i].suburb == "toowong"){
            patrons[i].suburb = "TW";
        } else if(patrons[i].suburb == "taringa"){
            patrons[i].suburb = "TR";
        } else if(patrons[i].suburb == "auchenflower"){
            patrons[i].suburb = "AU";
        } else if(patrons[i].suburb == "indooroopilly"){
            patrons[i].suburb = "IN";
        } else if(patrons[i].suburb == "chapelhill"){
            patrons[i].suburb = "CA";
        } else if(patrons[i].suburb == "kelvingrove"){
            patrons[i].suburb = "KA";
        } else if(patrons[i].suburb == "woolongabba" || patrons[i].suburb == "duttonpark"
            || patrons[i].suburb == "fairfield" || patrons[i].suburb == "annerley"){
            patrons[i].suburb = "WA";
        } else if(patrons[i].suburb == "oxley" || patrons[i].suburb == "sherwood"
            || patrons[i].suburb == "corinda"){
            patrons[i].suburb = "OA";
        } else if(patrons[i].suburb == "sunnybank" || patrons[i].suburb == "willawong"
            || patrons[i].suburb == "logan"){
            patrons[i].suburb = "SA";
        }
    }
}

// setTimeout(function(){
//    window.location.reload(1);
// }, 120000);

</script>

@endsection