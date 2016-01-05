@extends('app')

@section('content')
<style>
    input[type='checkbox'] {
        width: 25px;
        height: 25px;
    }
    @media (max-width : 400px) {
        input[type='checkbox'] {
            width: 45px;
            height: 45px;
        }
        .patronDetailRow{
            min-height: 55px;
        }
        .eventColumn{
            display:none;
        }
        .panel-body{
            padding-left:23px;
        }
    }
</style>
<div class='row'>
	<div class="col-md-2 eventColumn">
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
                        <div class="col-xs-2 col-md-1">
                            <img src="{{$patron->picurl}}" alt="patronPic" class="img-thumbnail" style="width: 100%"> 
                        </div>
                        <div class="col-xs-8 col-md-4 patronDetailRow">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{url('patron/'.$patron->id)}}">{{$patron->name}}</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="font-size: .8em;">{{$patron->address}}, {{$patron->suburb}}</div>
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
                        <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronThere{{$counter++}}" style="display: none">
                        <p id="textPatronThere{{$counter-1}}" style="display: none">{{$patron3->name}}</p>
                    </div>
                    @else
                    <div class="col-xs-2 col-md-2">
                        <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronThere{{$counter++}}" style="display: none">
                        <p id="textPatronThere{{$counter-1}}" style="display: none">{{$patron3->name}}</p>
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
            <div class="panel-heading"><a data-toggle="collapse" href="#transportBackList">Transport - Back</a></div>
            <div class="panel-body collapse in" id="transportBackList">
                <div style="display:none">{{$counter = 1}}</div>
                @foreach ($patronsInEvent as $patron3) 
                    @if ($patron3->id % 5 == 1)
                    <div class="row" id="transportBack{{ceil ($patron3->id/5)}}">
                    <div class="col-xs-3 col-md-3">
                        <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronBack{{$counter++}}" style="display: none">
                        <p id="textPatronBack{{$counter-1}}" style="display: none">{{$patron3->name}}</p>
                    </div>
                    @else
                    <div class="col-xs-2 col-md-2">
                        <img src="{{$patron3->picurl}}" class="img-thumbnail" alt="patronPic" id="imgPatronBack{{$counter++}}" style="display: none">
                        <p id="textPatronBack{{$counter-1}}" style="display: none">{{$patron3->name}}</p>
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
	</div>
</div>



@include('dev.createModal')

<script>
var arrayPatron = [];
var arrayNearBySet = [];
suburbs = {
    SLSL:1, SLTW:2, SLTR:2, SLAU:3, SLIN:3, SLCA:4, SLKA:5, SLWA:6, SLOA:6, SLSA:7,
    TWSL:2, TWTW:1, TWTR:2, TWAU:2, TWIN:3, TWCA:4, TWKA:4, TWWA:5, TWOA:6, TWSA:6, 
    TRSL:2, TRTW:2, TRTR:1, TRAU:3, TRIN:2, TRCA:3, TRKA:5, TRWA:6, TROA:5, TRSA:7,
    AUSL:3, AUTW:2, AUTR:2, AUAU:1, AUIN:4, AUCA:5, AUKA:3, AUWA:4, AUOA:7, AUSA:5,
    INSL:3, INTW:3, INTR:2, INAU:4, ININ:1, INCA:2, INKA:6, INWA:7, INOA:3, INSA:6, 
    CASL:4, CATW:4, CATR:3, CAAU:5, CAIN:2, CACA:1, CAKA:7, CAWA:8, CAOA:4, CASA:9, 
    KASL:5, KATW:5, KATR:5, KAAU:3, KAIN:6, KACA:7, KAKA:1, KAWA:3, KAOA:7, KASA:5, 
    WASL:6, WATW:5, WATR:6, WAAU:4, WAIN:7, WACA:8, WAKA:3, WAWA:1, WAOA:8, WASA:3, 
    OASL:6, OATW:6, OATR:5, OAAU:7, OAIN:3, OACA:4, OAKA:7, OAWA:8, OAOA:1, OASA:4, 
    SASL:7, SATW:6, SATR:7, SAAU:5, SAIN:6, SACA:9, SAKA:5, SAWA:3, SAOA:4, SASA:1 
};
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
            //console.log(data);
        });
    });

    //=== CarBackOptions Ajax calls ===//
    $('.carbackOptions').on('change', function (e) {
        var tempVar = $(this).children(":selected").attr("id").substring(7).split('-');
        var patronId = tempVar[0];
        var driverId = tempVar[1];
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
            }
            console.log(JSON.stringify(arrayPatron));
            console.log(JSON.stringify(arrayNearBySet));

            var plan = runTransportAlgorithm(arrayPatron, arrayNearBySet);
            var planThere = plan[0];
            var planBack = plan[1];
            console.log(plan);
            var counter = 1;
            planThere.forEach(function(car) {
                car.forEach(function(passenger){
                    $('#imgPatronThere'+counter).show();
                    $('#textPatronThere'+counter).show();
                    $('#imgPatronThere'+counter).attr('src', passenger.picurl);
                    $('#textPatronThere'+counter).html(passenger.name);
                    counter++;
                });
                if (counter%5 != 1){
                    counter = ((Math.ceil(counter/5))*5)+1;
                }
            });
            counter=1;
            planBack.forEach(function(car) {
                car.forEach(function(passenger){
                    $('#imgPatronBack'+counter).show();
                    $('#textPatronBack'+counter).show();
                    $('#imgPatronBack'+counter).attr('src', passenger.picurl);
                    $('#textPatronBack'+counter).html(passenger.name);
                    counter++;
                });
                if (counter%5 != 1){
                    counter = ((Math.ceil(counter/5))*5)+1;
                }
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

    processSuburbMappings(patrons);

    for(var i = 0; i < patrons.length; i++){
        if(patrons[i].carthere == "driving"){
            driversThere.push(patrons[i]);
        } else {
            passengersThere.push(patrons[i]);
        }
        if(patrons[i].carback == "driving"){
            driversBack.push(patrons[i]);
        } else {
            passengersBack.push(patrons[i]);
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
    for(var i = 0; i < passengersThere.length; i++){
        if(passengersThere[i].carthere != "none" && passengersThere[i].carthere != "driving" &&
            passengersThere[i].carthere != "staying"  && passengersThere[i].carthere != "any"){
            carsThere[driverIDIndexInCarList(carsThere, passengersThere[i].carthere)].push(passengersThere[i]);
        } else if(passengersThere[i].carthere == "none" || passengersThere[i].carthere == "staying"){
            passengersThere.splice(i, 1);
        }
    }

    removeProcessedPassengers(passengersThere, carsThere);

    for(var i = 0; i < passengersBack.length; i++){
        if(passengersBack[i].carback != "none" && passengersBack[i].carback != "driving" &&
            passengersBack[i].carback != "staying"  && passengersBack[i].carback != "any"){
            carsBack[driverIDIndexInCarList(carsBack, passengersBack[i].carback)].push(passengersBack[i]);
        } else if(passengersBack[i].carback == "none" || passengersBack[i].carback == "staying"){
            passengersBack.splice(i, 1);
        }
    }

    removeProcessedPassengers(passengersBack, carsBack);

    processPlan(carsThere, passengersThere, nearbySetsList);
    processPlan(carsBack, passengersBack, nearbySetsList);
    return new Array(carsThere, carsBack);
}


function processPlan(carsList, passengersList, nearbySetsList){
    /* Remove the nearby sets that are not relevant to the current transport plan 
    this means that there are not at least two patrons of the nearby set that are attending the event. */

    relevantNearbySets = 
        processNearbySetsFromPassengerList(nearbySetsList, passengersList);
    
    matchedNearbySets = new Array();

    for(var i = 0; i < relevantNearbySets.length; i++){
        if(relevantNearbySets[i].length == 2){
            for(var j = i + 1; j < relevantNearbySets.length; j++){
                if(relevantNearbySets[j].length == 2 
                    && relevantNearbySets[i].suburb == relevantNearbySets[j].suburb){
                    matchedNearbySets.push(relevantNearbySets[i].concat(relevantNearbySets[j]));
                    relevantNearbySets.splice(j, 1);
                }
            }
        } else {
            matchedNearbySets.push(relevantNearbySets[i]);
        }
    }

    /* Process the nearby sets into their cars */
    for(var i = 0; i < matchedNearbySets.length; i++){
        var bestDriver = calculateBestDriver(carsList, matchedNearbySets[i][0]);
        for(var j = 0; j < matchedNearbySets[i].length; j++){
            carsList[driverIDIndexInCarList(carsList, bestDriver.patron_id)].push(
                matchedNearbySets[i][j]);
        }   
    }

    removeProcessedPassengers(passengersList, carsList);

    /* Process passengers which share the same suburb as a driver */
    for(var i = 0; i < passengersList.length; i++){

    }

    /* Process the remaining passengers into their cars */
    for(var i = 0; i < passengersList.length; i++){
        var bestDriver = calculateBestDriver(carsList, passengersList[i]);
        carsList[driverIDIndexInCarList(carsList, bestDriver.patron_id)].push(
            passengersList[i]);
    }

    removeProcessedPassengers(passengersList, carsList);
}

/* Takes a set of cars and a passenger, returns the best driver for the 
passenger. If the most efficient driver has a full car, then the next most efficient 
driver that does not have a full car is the best driver. */
function calculateBestDriver(cars, patron){
    var i = 0;
    var bestDriver = cars[i][0];
    var currentSuburbPairRank = suburbs[String(patron.suburb).concat(cars[i][0].suburb)];
    while(cars[i].length > 4){
        i++;
        bestDriver = cars[i][0];
        currentSuburbPairRank = suburbs[String(patron.suburb).concat(cars[i][0].suburb)];
    }
    for(; i < cars.length; i++){
        if(suburbs[String(patron.suburb).concat(cars[i][0].suburb)] < currentSuburbPairRank
            && cars[i].length < 5){
            currentSuburbPairRank = suburbs[String(patron.suburb).concat(cars[i][0].suburb)];
            bestDriver = cars[i][0];
        }
    }
    return bestDriver;
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
        if(patrons[i].suburb == "Stlucia"){
            patrons[i].suburb = "SL";
        } else if(patrons[i].suburb == "Toowong"){
            patrons[i].suburb = "TW";
        } else if(patrons[i].suburb == "Taringa"){
            patrons[i].suburb = "TR";
        } else if(patrons[i].suburb == "Auchenflower"){
            patrons[i].suburb = "AU";
        } else if(patrons[i].suburb == "Indooroopilly"){
            patrons[i].suburb = "IN";
        } else if(patrons[i].suburb == "Chapelhill"){
            patrons[i].suburb = "CA";
        } else if(patrons[i].suburb == "Kelvingrove"){
            patrons[i].suburb = "KA";
        } else if(patrons[i].suburb == "Woolongabba" || patrons[i].suburb == "Duttonpark"
            || patrons[i].suburb == "Fairfield" || patrons[i].suburb == "Annerley"){
            patrons[i].suburb = "WA";
        } else if(patrons[i].suburb == "Oxley" || patrons[i].suburb == "Sherwood"
            || patrons[i].suburb == "Corinda"){
            patrons[i].suburb = "OA";
        } else if(patrons[i].suburb == "Sunnybank" || patrons[i].suburb == "Willawong"
            || patrons[i].suburb == "Logan"){
            patrons[i].suburb = "SA";
        }
    }
}

// setTimeout(function(){
//    window.location.reload(1);
// }, 120000);

</script>

@endsection