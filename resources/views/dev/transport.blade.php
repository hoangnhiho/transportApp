@extends('app')

@section('content')
<?php $defaultImg = 'https://scontent-hkg3-1.xx.fbcdn.net/hphotos-xpa1/v/t1.0-9/940909_10154104345177269_4110317739830709958_n.jpg?oh=21327a6e1ea096bebb8c9e370accf2f4&oe=57BC9A6F'; ?>
<style>
    input[type='checkbox'] {
        width: 25px;
        height: 25px;
    }
    @media (max-width : 436px) {
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
    .passenger-container { 
        height:60px;
        width:60px;
    }
    @media (min-width : 436px) and (max-width : 520px){
      /* some CSS here */
        .patronDetailRow{
            min-height: 55px;
        }
        input[type='checkbox'] {
            width: 45px;
            height: 45px;
        }
        .displayPic{
            max-width: 60px;
        }
        .img-thumbnail{
            width: 50px !important;
        }
    }
    @media (min-width : 521px) and (max-width : 991px){
        input[type='checkbox'] {
            width: 70px;
            height: 70px;
        }
    }
    .name-tagOverlay {
      position: absolute;
      min-height:5px;
      min-width:20px;
      height: 25%;
      width: 90%;
      top: 65%;
      opacity: 0.6;
      background-size: cover;
      background-image: url("{{ URL::to('/') }}/img/name-tag.png");
      color: white;
      font-weight: bold;
      font-size: 9px;
      padding-left: 4px;
      padding-top: 1px;
    }
    .patron-square {
        -webkit-filter: grayscale(100%);
        filter: grayscale(100%);
        padding: 1px !important;
        opacity:0.4;
    }
    .active-square {
        -webkit-filter: grayscale(0%);
        filter: grayscale(0%);
        opacity:1;
    }
    .active-driver-square {
        /*display:block;*/
    }
    .driver-tagOverlay {
      position: absolute;
      min-height:15px;
      min-width:5px;
      height: 100%;
      width: 100%;
      top: 0%;
      right: 0%;
      opacity: 0.8;
      background-size: cover;
      background-image: url("{{ URL::to('/') }}/img/driver-tag.png");
    }

</style>
<div class='row' style="width:95%;margin:auto">
    <div class="col-md-3 dummyColumn" style="display:none"></div>
	<div class="col-md-2 eventColumn" style="display:none">
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
                @if (!isset($publicShow))
                <button type="button" class="btn btn-danger btn-sm pull-right" id="clearAllBtn" style="padding: 2px 5px 0px 5px; margin-left:3px;">
                    Clear All
                </button>
                @endif
                </div>
            </div>
			<div class="panel-body collapse in" id='patronList'>
                <div>
                    <!--<div class="row">
                        <div class="col-md-1">
                           
                        </div>
                        <div class="col-xs-12 col-md-5"><b>Patron's details</b></div>
                        <div class="col-xs-6 col-md-3"><b>Pref To</b></div>
                        <div class="col-xs-6 col-md-3"><b>Pref Back</b></div>
                    </div>
                    <hr class="col-xs-12 col-md-12" style="margin-top: 0px; margin-bottom: 10px;">-->
                    <div class="row">
                        <div class="col-xs-1 col-md-1"></div>
                        <div id="sort-all" class="col-xs-1 col-md-1 btn btn-primary active sort-selection">All</div>
                        <div id="sort-AD" class="col-xs-1 col-md-1 btn btn-primary sort-selection">A-D</div>
                        <div id="sort-EG" class="col-xs-1 col-md-1 btn btn-primary sort-selection">E-G</div>
                        <div id="sort-HL" class="col-xs-1 col-md-1 btn btn-primary sort-selection">H-L</div>
                        <div id="sort-MQ" class="col-xs-1 col-md-1 btn btn-primary sort-selection">M-Q</div>
                        <div id="sort-RV" class="col-xs-1 col-md-1 btn btn-primary sort-selection">R-V</div>
                        <div id="sort-WZ" class="col-xs-1 col-md-1 btn btn-primary sort-selection">W-Z</div>
                        <div id="sort-grid" class="col-xs-1 col-md-1 btn btn-primary active sort-selection">Grid</div>
                        <div class="col-xs-2 col-md-2"></div>
                    </div>
                    <hr class="col-xs-12 col-md-12" style="margin-top: 0px; margin-bottom: 10px;">
                </div>
                
                
                <div id="patron-grid">
                    <div id="AD-header" class="col-xs-12 col-sm-12 col-md-12 alpha-header" style="color:navy">A-D</div>
                    <div id="grid-AD">
                        @foreach ($patronsInEvent as $patron) 
                            @if ($patron->name[0] == "A" || $patron->name[0] == "B" ||  $patron->name[0] == "C" ||  $patron->name[0] == "D")
                                <div id="square-{{$patron->id}}" data-name="{{$patron->name}}" class="patron-square @if ($patron->softDelete =='1') active-square @endif @if ($patron->carthere == 'driving') active-driver-square @endif col-xs-2 col-sm-2 col-md-2" style="padding:0px">
                                    <img src="{{$patron->picurl}}" class="img-square" style="width:100%" onError="this.src='{{$defaultImg}}';">
                                    <div class="name-tagOverlay">{{$patron->name}}</div>
                                    <div class="driver-tagOverlay"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div id="EG-header" class="col-xs-12 col-sm-12 col-md-12 alpha-header" style="color:navy">E-G</div>
                    <div id="grid-EG">
                        @foreach ($patronsInEvent as $patron) 
                            @if ($patron->name[0] == "E" || $patron->name[0] == "F" ||  $patron->name[0] == "G")
                                <div id="square-{{$patron->id}}" data-name="{{$patron->name}}" class="patron-square @if ($patron->softDelete =='1') active-square @endif @if ($patron->carthere == 'driving') active-driver-square @endif col-xs-2 col-sm-2 col-md-2" style="padding:0px">
                                    <img src="{{$patron->picurl}}" class="img-square" style="width:100%" onError="this.src='{{$defaultImg}}';">
                                    <div class="name-tagOverlay">{{$patron->name}}</div>
                                    <div class="driver-tagOverlay"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div id="HL-header" class="col-xs-12 col-sm-12 col-md-12 alpha-header" style="color:navy">H-L</div>
                    <div id="grid-HL">
                        @foreach ($patronsInEvent as $patron) 
                            @if ($patron->name[0] == "H" || $patron->name[0] == "I" ||  $patron->name[0] == "J" ||  $patron->name[0] == "K" ||  $patron->name[0] == "L")
                                <div id="square-{{$patron->id}}" data-name="{{$patron->name}}" class="patron-square @if ($patron->softDelete =='1') active-square @endif @if ($patron->carthere == 'driving') active-driver-square @endif col-xs-2 col-sm-2 col-md-2" style="padding:0px">
                                    <img src="{{$patron->picurl}}" class="img-square" style="width:100%" onError="this.src='{{$defaultImg}}';">
                                    <div class="name-tagOverlay">{{$patron->name}}</div>
                                    <div class="driver-tagOverlay"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div id="MQ-header" class="col-xs-12 col-sm-12 col-md-12 alpha-header" style="color:navy">M-Q</div>
                    <div id="grid-MQ">
                        @foreach ($patronsInEvent as $patron) 
                            @if ($patron->name[0] == "M" || $patron->name[0] == "N" ||  $patron->name[0] == "O" ||  $patron->name[0] == "P" ||  $patron->name[0] == "Q")
                                <div id="square-{{$patron->id}}" data-name="{{$patron->name}}" class="patron-square @if ($patron->softDelete =='1') active-square @endif @if ($patron->carthere == 'driving') active-driver-square @endif col-xs-2 col-sm-2 col-md-2" style="padding:0px">
                                    <img src="{{$patron->picurl}}" class="img-square" style="width:100%" onError="this.src='{{$defaultImg}}';">
                                    <div class="name-tagOverlay">{{$patron->name}}</div>
                                    <div class="driver-tagOverlay"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div id="RV-header" class="col-xs-12 col-sm-12 col-md-12 alpha-header" style="color:navy">R-V</div>
                    <div id="grid-RV">
                        @foreach ($patronsInEvent as $patron) 
                            @if ($patron->name[0] == "R" || $patron->name[0] == "S" ||  $patron->name[0] == "T" ||  $patron->name[0] == "U" ||  $patron->name[0] == "V")
                                <div id="square-{{$patron->id}}" data-name="{{$patron->name}}" class="patron-square @if ($patron->softDelete =='1') active-square @endif @if ($patron->carthere == 'driving') active-driver-square @endif col-xs-2 col-sm-2 col-md-2" style="padding:0px">
                                    <img src="{{$patron->picurl}}" class="img-square" style="width:100%" onError="this.src='{{$defaultImg}}';">
                                    <div class="name-tagOverlay">{{$patron->name}}</div>
                                    <div class="driver-tagOverlay"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div id="WZ-header" class="col-xs-12 col-sm-12 col-md-12 alpha-header" style="color:navy">W-Z</div>
                    <div id="grid-WZ">
                        @foreach ($patronsInEvent as $patron) 
                            @if ($patron->name[0] == "W" || $patron->name[0] == "X" ||  $patron->name[0] == "Y" ||  $patron->name[0] == "Z")
                                <div id="square-{{$patron->id}}" data-name="{{$patron->name}}" class="patron-square @if ($patron->softDelete =='1') active-square @endif @if ($patron->carthere == 'driving') active-driver-square @endif col-xs-2 col-sm-2 col-md-2" style="padding:0px">
                                    <img src="{{$patron->picurl}}" class="img-square" style="width:100%" onError="this.src='{{$defaultImg}}';">
                                    <div class="name-tagOverlay">{{$patron->name}}</div>
                                    <div class="driver-tagOverlay"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div id="patron-rows">
                @foreach ($patronsInEvent as $patron) 
                    <div id="row-{{$patron->name}}" class="row patron-row">
                        <div class="col-xs-2 col-md-1">
                            <input type="checkbox" id="patron{{$patron->id}}" @if ($patron->softDelete =='1') checked @endif> 
                        </div>
                        <div class="col-xs-2 col-sm-3 col-md-2 displayPic">
                            <img src="{{$patron->picurl}}" alt="patronPic" class="img-thumbnail" style="width: 100%" onError="this.src='{{$defaultImg}}';"> 
                        </div>
                        <div class="col-xs-8 col-sm-7 col-md-3 patronDetailRow">
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
                                <option id="carthere{{$patron->id}}-none" @if($patron->carthere == 'none') selected @endif>None</option>
                                <option id="carthere{{$patron->id}}-any" @if($patron->carthere == 'any') selected @endif>Passenger</option>
                                <option id="carthere{{$patron->id}}-driving" @if($patron->carthere == 'driving') selected @endif>Driver</option>
                                @if (!isset($publicShow))
                                    @foreach ($patronsInEvent as $patron1) 
                                        @if ($patron1->carthere == 'driving' && $patron->id != $patron1->id )
                                            <option id="carthere{{$patron->id}}-{{$patron1->id}}" @if($patron->carthere == $patron1->id) selected @endif>{{$patron1->name}}</option>
                                        @elseif ($patron1->carthere != 'driving' && $patron->carthere != 'none' && $patron->carthere != 'any' && $patron->carthere != 'driving' && $patron->carthere == $patron1->id && $patron->id != $patron1->id)
                                            <option id="carthere{{$patron->id}}-{{$patron1->id}}" @if($patron->carthere == $patron1->id) selected @endif>{{$patron1->name}}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @if($patron->carthere == 'pEarly' || $patron->carthere == 'pLate' || $patron->carthere == 'dEarly' || $patron->carthere == 'dLate' )
                                        <option id="carthere{{$patron->id}}-{{$patron->carthere}}"  selected >{{$patron->carthere}}</option>
                                    @endif
                                @endif
                            </select>
                        </div>
                        <div class="col-xs-6 col-md-3">
                            <select class="form-control carbackOptions">
                                <option selected="selected" id="carback{{$patron->id}}-none" @if($patron->carback == 'none') selected @endif>None</option>
                                <option id="carback{{$patron->id}}-any" @if($patron->carback == 'any') selected @endif>Passenger</option>
                                <option id="carback{{$patron->id}}-driving" @if($patron->carback == 'driving') selected @endif>Driver</option>
                                @if (!isset($publicShow))
                                    @foreach ($patronsInEvent as $patron2) 
                                        @if ($patron2->carback == 'driving' && $patron->id != $patron2->id)
                                            <option id="carback{{$patron->id}}-{{$patron2->id}}" @if($patron->carback == $patron2->id) selected @endif>{{$patron2->name}}</option>
                                        @elseif ($patron2->carback != 'driving' && $patron->carback != 'none' && $patron->carback != 'any' && $patron->carback != 'driving' && $patron->carback == $patron2->id && $patron->id != $patron2->id)
                                            <option id="carback{{$patron->id}}-{{$patron2->id}}" @if($patron->carback == $patron2->id) selected @endif>{{$patron2->name}}</option>
                                        @endif
                                    @endforeach
                                @else
                                    @if($patron->carback == 'pEarly' || $patron->carback == 'pLate' || $patron->carback == 'dEarly' || $patron->carback == 'dLate' )
                                        <option id="carback{{$patron->id}}-{{$patron->carback}}"  selected >{{$patron->carback}}</option>
                                    @endif
                                @endif
                            </select>
                        </div>
                    </div>
                    
                @endforeach
                </div>
                
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
                
        
            </div>
        </div><!-- close Panel-->
        <div class="panel panel-default" id="walkingTherePanel">
            <div class="panel-heading"><a data-toggle="collapse" href="#walkingThereList">Walkers - There</a></div>
            <div class="panel-body collapse in" id="walkingThereList">

            </div>
        </div>
    </div><!-- close mod-md-3 -->
    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading"><a data-toggle="collapse" href="#transportBackList">Transport - Back</a></div>
            <div class="panel-body collapse in" id="transportBackList">

            </div>
        </div>
        <div class="panel panel-default" id="walkingBackPanel">
            <div class="panel-heading"><a data-toggle="collapse" href="#walkingBackList">Walkers - Back</a></div>
            <div class="panel-body collapse in" id="walkingBackList">

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
    $('#patron-rows').hide();

    $("#grid-AD").children().each(function(){
        if(!$(this).hasClass('active-driver-square')){
            $(this).children('.driver-tagOverlay').hide();
        }
    });
    $("#grid-EG").children().each(function(){
        if(!$(this).hasClass('active-driver-square')){
            $(this).children('.driver-tagOverlay').hide();
        }
    });
    $("#grid-HL").children().each(function(){
        if(!$(this).hasClass('active-driver-square')){
            $(this).children('.driver-tagOverlay').hide();
        }
    });
    $("#grid-MQ").children().each(function(){
        if(!$(this).hasClass('active-driver-square')){
            $(this).children('.driver-tagOverlay').hide();
        }
    });
    $("#grid-RV").children().each(function(){
        if(!$(this).hasClass('active-driver-square')){
            $(this).children('.driver-tagOverlay').hide();
        }
    });
    $("#grid-WZ").children().each(function(){
        if(!$(this).hasClass('active-driver-square')){
            $(this).children('.driver-tagOverlay').hide();
        }
    });

	//Page load settings
    var URL = window.location.origin;
	var eventID = {!!$eventID!!};
    @if (isset($publicShow))
        $('.eventColumn').hide();
        //$('.patronColumn').hide();
        //$('.dummyColumn').show();
    @endif
    
    //Collapses all panels if mobile.
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
          //$('#patronList').collapse('hide');
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

    $('.patron-square').on('click', function() {
        var patronID = $(this).attr("id").substring(7);
        //console.log(patronID);
        var $this = $(this);
        if($(this).hasClass("active-square") && $(this).hasClass("active-driver-square")){//change to none

            $.get( "/changeEventPatronStatus/"+eventID+"/"+patronID+"/"+"none").success(function(data){
                $this.removeClass("active-square");
                $this.removeClass("active-driver-square");
                $this.find('.driver-tagOverlay').hide();
                $('#carthere'+patronID+'-none').prop('selected', true);
                $('#carback'+patronID+'-none').prop('selected', true);
                $('#patron'+patronID).attr('checked', false); 
            });
        } else if ($(this).hasClass("active-square")){//change to driving
            $.get( "/changeEventPatronStatus/"+eventID+"/"+patronID+"/"+"driving").success(function(data){
                $this.addClass("active-driver-square");
                $this.find('.driver-tagOverlay').show();
                $('#carthere'+patronID+'-driving').prop('selected', true);
                $('#carback'+patronID+'-driving').prop('selected', true);
                $('#patron'+patronID).attr('checked', true); 
            });
        } else {//change to any
            $.get( "/changeEventPatronStatus/"+eventID+"/"+patronID+"/"+"any").success(function(data){
                $('#carthere'+patronID+'-any').prop('selected', true);
                $('#carback'+patronID+'-any').prop('selected', true);
                $('#patron'+patronID).attr('checked', true); 
                $this.addClass("active-square");
            });
        }
    });

    //=== show All ===//
    $('#sort-all').on('click', function() {
        if($(this).hasClass('active')){
            $(this).removeClass('active');
        } else {
            $(this).addClass('active');
            removeActiveSortSelections();
            $("#patron-rows").children().each(function(){
                $(this).show();
            });  
            $("#grid-AD").children().each(function(){
                $(this).show();
            });
            $("#grid-EG").children().each(function(){
                $(this).show();
            });
            $("#grid-HL").children().each(function(){
                $(this).show();
            });
            $("#grid-MQ").children().each(function(){
                $(this).show();
            });
            $("#grid-RV").children().each(function(){
                $(this).show();
            });
            $("#grid-WZ").children().each(function(){
                $(this).show();
            });
            $("#patron-grid").find(".alpha-header").each(function(){
                //console.log($(this).attr('id'));
                $(this).show();                                  
            });
        }
    });

    //=== show A-D ===//
    $('#sort-AD').on('click', function() {
        removeActiveSortSelections();
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            showOrDisplay();
        } else {
            $('#sort-all').removeClass('active');
            $(this).addClass('active');
            showOrDisplay();
        }
    });

    //=== show E-G ===//
    $('#sort-EG').on('click', function() {
        removeActiveSortSelections();
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            showOrDisplay();
        } else {
            $('#sort-all').removeClass('active');
            $(this).addClass('active');
            showOrDisplay();
        } 
    });

    //=== show H-L ===//
    $('#sort-HL').on('click', function() {
        removeActiveSortSelections();
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            showOrDisplay();
        } else {
            $('#sort-all').removeClass('active');
            $(this).addClass('active');
            showOrDisplay();
        }
    });

    //=== show M-Q ===//
    $('#sort-MQ').on('click', function() {
        removeActiveSortSelections();
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            showOrDisplay();
        } else {
            $('#sort-all').removeClass('active');
            $(this).addClass('active');
            showOrDisplay();
        }
    });

    //=== show R-V ===//
    $('#sort-RV').on('click', function() {
        removeActiveSortSelections();
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            showOrDisplay();
        } else {
            $('#sort-all').removeClass('active');
            $(this).addClass('active');
            showOrDisplay();
        }
    });

    //=== show W-Z ===//
    $('#sort-WZ').on('click', function() {
        removeActiveSortSelections();
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            showOrDisplay();
        } else {
            $('#sort-all').removeClass('active');
            $(this).addClass('active');
            showOrDisplay();
        }
    });
    
    //=== show Grid ===//
    $('#sort-grid').on('click', function() {
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            $("#patron-rows").show();
            $('#patron-grid').hide();
        } else {
            $(this).addClass('active');
            // $("#patron-rows").children().each(function(){
            //     $(this).hide();
            // }); 
            $("#patron-rows").hide();
            $('#patron-grid').show();
        }
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
    //=== clear all / uncheck all boxes ===//
    $("#clearAllBtn").on('click', function(){
        $('input:checkbox').removeAttr('checked');
        $('.carthereOptions').val($(".carthereOptions option:first").val());
        $('.carbackOptions').val($(".carbackOptions option:first").val());
        $('.patron-square').removeClass('active-square');
        $('.patron-square').removeClass('active-driver-square');
        $('.driver-tagOverlay').hide();
        $.get( "/clearAllPatron/"+eventID, function( data ) {});
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
        if (driverId == 'driving'){
            $.get( "/postCarBack/"+eventID+"/"+patronId+"/"+driverId, function( data ) {
                //console.log(data);
                $('#carback'+patronId+'-driving').prop('selected', true);
            });
        }
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

    function removeActiveSortSelections(){
        $('#sort-AD').removeClass('active');
        $('#sort-EG').removeClass('active');
        $('#sort-HL').removeClass('active');
        $('#sort-MQ').removeClass('active');
        $('#sort-RV').removeClass('active');
        $('#sort-WZ').removeClass('active');
    }

    function showOrDisplay(){
        $("#patron-rows").children().each(function(){
            if($('#sort-AD').hasClass('active') &&
                ($(this).attr('id').toLowerCase().substring(4,5) == 'a' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'b' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'c' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'd')){
                $(this).show();
            } else if($('#sort-EG').hasClass('active') &&
                ($(this).attr('id').toLowerCase().substring(4,5) == 'e' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'f' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'g')){
                $(this).show();
            } else if($('#sort-HL').hasClass('active') &&
                ($(this).attr('id').toLowerCase().substring(4,5) == 'h' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'i' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'i' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'k' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'l')){
                $(this).show();
            } else if($('#sort-MQ').hasClass('active') &&
                ($(this).attr('id').toLowerCase().substring(4,5) == 'm' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'n' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'o' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'p' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'q')){
                $(this).show();
            } else if($('#sort-RV').hasClass('active') &&
                ($(this).attr('id').toLowerCase().substring(4,5) == 'r' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 's' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 't' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'u' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'v')){
                $(this).show();
            } else if($('#sort-WZ').hasClass('active') &&
                ($(this).attr('id').toLowerCase().substring(4,5) == 'w' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'x' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'y' ||
                $(this).attr('id').toLowerCase().substring(4,5) == 'z')){
                $(this).show();
            } else {
                $(this).hide();
            }
        }); 
        $("#grid-AD").children().each(function(){
            if($('#sort-AD').hasClass('active') &&
                ($(this).attr('data-name').toLowerCase().substring(0,1) == 'a' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'b' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'c' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'd')){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $("#grid-EG").children().each(function(){
            if($('#sort-EG').hasClass('active') &&
                ($(this).attr('data-name').toLowerCase().substring(0,1) == 'e' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'f' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'g')){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $("#grid-HL").children().each(function(){
            if($('#sort-HL').hasClass('active') &&
                ($(this).attr('data-name').toLowerCase().substring(0,1) == 'h' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'i' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'j' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'k' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'l')){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $("#grid-MQ").children().each(function(){
            if($('#sort-MQ').hasClass('active') &&
                ($(this).attr('data-name').toLowerCase().substring(0,1) == 'm' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'n' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'o' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'q')){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $("#grid-RV").children().each(function(){
            if($('#sort-RV').hasClass('active') &&
                ($(this).attr('data-name').toLowerCase().substring(0,1) == 'r' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 's' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 't' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'u' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'v')){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $("#grid-WZ").children().each(function(){
            if($('#sort-WZ').hasClass('active') &&
                ($(this).attr('data-name').toLowerCase().substring(0,1) == 'w' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'x' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'y' ||
                $(this).attr('data-name').toLowerCase().substring(0,1) == 'z')){
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        $("#patron-grid").find(".alpha-header").each(function(){
            //console.log($(this).attr('id'));
            $(this).hide();            
        });
        if($('#sort-AD').hasClass('active')){
            $("#AD-header").show();
        } else if($('#sort-EG').hasClass('active')){
            $("#EG-header").show();
        } else if($('#sort-HL').hasClass('active')){
            $("#HL-header").show();
        } else if($('#sort-MQ').hasClass('active')){
            $("#MQ-header").show();
        } else if($('#sort-RV').hasClass('active')){
            $("#RV-header").show();
        } else if($('#sort-WZ').hasClass('active')){
            $("#WZ-header").show();
        }          
    }
    
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

            //console.log(JSON.stringify(arrayPatron));
            //console.log(JSON.stringify(arrayNearBySet));

            var plan = runTransportAlgorithm(arrayPatron, arrayNearBySet);
            var planThere = plan[0];
            var planBack = plan[1];
            var walkThere = plan[2];
            var walkBack = plan[3];

            if (walkThere.length == 0) {
                $('#walkingTherePanel').hide();
            }
            if (walkBack.length == 0) {
                $('#walkingBackPanel').hide();
            }
            console.log(plan);
            //console.log(walkThere);
            //console.log(planBack);

            var tempHTMLstring = '';
            var carCounter = 1;
            var carPassenger = 1;
            planThere.forEach(function(car) {
                tempHTMLstring += '<div class="row" id="transportThere'+carCounter+'">';
                car.forEach(function(passenger){
                    //tempHTMLstring += '<div class="col-xs-2 col-md-2"><a data-toggle="modal" id="modalPatronThere'+passenger.id+'" href="'+URL+'/getModalPatron/'+passenger.id+'" data-target="#patronModal"><img src="'+passenger.picurl+'" class="img-thumbnail" alt="patronPic" id="imgPatronThere'+passenger.id+'"></a><p id="textPatronThere'+passenger.id+'">'+passenger.name+'</p></div>'
                    var tag_color = mapSubCodeToColor(passenger.suburb);
                    //if (carPassenger == 1){
                    //    tempHTMLstring +=   '<div class="col-xs-3 col-md-3">';
                    //}else{
                        tempHTMLstring +=   '<div class="col-xs-2 col-md-2">';
                    //}
                     tempHTMLstring += '<a data-toggle="modal" id="modalPatronThere'+passenger.id+'" href="'+URL+'/getModalPatron/'+passenger.id+'" data-target="#patronModal">'+
                                                '<div><img src="'+passenger.picurl+'" class="img-thumbnail" alt="patronPic" id="imgPatronThere'+passenger.id+'" onError="this.src=\'{{$defaultImg}}\';"><img class="colored-tag" src="{{ URL::to('/') }}/img/'+tag_color+'-tag.png"></div>'+
                                            '</a>'+
                                            '<p id="textPatronThere'+passenger.id+'" class="name-field">'+passenger.name.substring(0, 8)+'</p>'+
                                        '</div>';
                                        carPassenger++;
                });
                tempHTMLstring += '</div>';
                carCounter++;
                carPassenger=1;
            });
            tempHTMLstring += '</div>';
            $('#transportThereList').append(tempHTMLstring);

            tempHTMLstring = '';
            carCounter = 1;
            carPassenger = 1;
            planBack.forEach(function(car) {
                tempHTMLstring += '<div class="row" id="transportBack'+carCounter+'">';
                car.forEach(function(passenger){
                    //tempHTMLstring += '<div class="col-xs-2 col-md-2"><a data-toggle="modal" id="modalPatronBack'+passenger.id+'" href="'+URL+'/getModalPatron/'+passenger.id+'" data-target="#patronModal"><img src="'+passenger.picurl+'" class="img-thumbnail" alt="patronPic" id="imgPatronBack'+passenger.id+'"></a><p id="textPatronBack'+passenger.id+'">'+passenger.name+'</p></div>'
                    var tag_color = mapSubCodeToColor(passenger.suburb);
                    //if (carPassenger == 1){
                    //    tempHTMLstring +=   '<div class="col-xs-3 col-md-3">';
                    //}else{
                        tempHTMLstring +=   '<div class="col-xs-2 col-md-2">';
                    //}
                     tempHTMLstring += '<a data-toggle="modal" id="modalPatronThere'+passenger.id+'" href="'+URL+'/getModalPatron/'+passenger.id+'" data-target="#patronModal">'+
                                                '<div><img src="'+passenger.picurl+'" class="img-thumbnail" alt="patronPic" id="imgPatronThere'+passenger.id+'" onError="this.src=\'{{$defaultImg}}\';"><img class="colored-tag" src="{{ URL::to('/') }}/img/'+tag_color+'-tag.png"></div>'+
                                            '</a>'+
                                            '<p id="textPatronThere'+passenger.id+'" class="name-field">'+passenger.name.substring(0, 8)+'</p>'+
                                        '</div>';
                                        carPassenger++;
                });
                tempHTMLstring += '</div>';
                carCounter++;
                carPassenger=1;
            });
            tempHTMLstring += '</div>';
            $('#transportBackList').append(tempHTMLstring);


            tempHTMLstring = '';
            walkThere.forEach(function(passenger) {
                    var tag_color = mapSubCodeToColor(passenger.suburb);
                    tempHTMLstring +=   '<div class="col-xs-2 col-md-2">'+
                                            '<a data-toggle="modal" id="modalPatronThere'+passenger.id+'" href="'+URL+'/getModalPatron/'+passenger.id+'" data-target="#patronModal">'+
                                                '<div><img src="'+passenger.picurl+'" class="img-thumbnail" alt="patronPic" id="imgPatronThere'+passenger.id+'"><img class="colored-tag" src="{{ URL::to('/') }}/img/'+tag_color+'-tag.png"></div>'+
                                            '</a>'+
                                            '<p id="textPatronThere'+passenger.id+'" class="name-field">'+passenger.name.substring(0, 8)+'</p>'+
                                        '</div>'
                tempHTMLstring += '</div>';
            });
            $('#walkingThereList').append(tempHTMLstring);

            tempHTMLstring = '';
            walkBack.forEach(function(passenger) {
                    var tag_color = mapSubCodeToColor(passenger.suburb);
                    tempHTMLstring +=   '<div class="col-xs-2 col-md-2">'+
                                            '<a data-toggle="modal" id="modalPatronBack'+passenger.id+'" href="'+URL+'/getModalPatron/'+passenger.id+'" data-target="#patronModal">'+
                                                '<div><img src="'+passenger.picurl+'" class="img-thumbnail" alt="patronPic" id="imgPatronBack'+passenger.id+'"><img class="colored-tag" src="{{ URL::to('/') }}/img/'+tag_color+'-tag.png"></div>'+
                                            '</a>'+
                                            '<p id="textPatronBack'+passenger.id+'" class="name-field">'+passenger.name.substring(0, 8)+'</p>'+
                                        '</div>'
                tempHTMLstring += '</div>';
            });
            $('#walkingBackList').append(tempHTMLstring);



        }, "json" );
    }
});

@include('dev.algorithm')

}

// setTimeout(function(){
//    window.location.reload(1);
// }, 120000);

</script>

@endsection