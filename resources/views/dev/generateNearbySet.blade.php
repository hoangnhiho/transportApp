@extends('app')

@section('content')
<style>
    input[type='checkbox'] {
        width: 25px;
        height: 25px;
    }
</style>
<div class='row'>
  <div class="col-md-2"></div>
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
          <div class="col-md-11"><b>Patron's details</b></div>
      </div>
      <hr style="margin-top: 0px; margin-bottom: 10px;">
        @foreach ($patrons as $patron) 
          <div class="row">
            <div class="col-md-1">
                <input type="checkbox" class="patronCheckBox" id="patron{{$patron->id}}" name="patron{{$patron->id}}"> 
            </div>
            <div class="col-md-1">
                <img class="img-thumbnail" src="{{$patron->picurl}}" alt="patronPic" height="42" width="42"> 
            </div>
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{url('patron/'.$patron->id)}}">{{$patron->id}} - {{$patron->name}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12" style="font-size: .8em;">{{$patron->address}}, {{$patron->suburb}}</div>
                </div>
            </div>
          </div>
          <p></p>
        @endforeach
      </div>
    </div>

    <button type="button" class="btn btn-primary" style="width: 100%" id="newNearbySet">
        <spam class="glyphicon glyphicon-cloud-upload" aria-hidden="true"></spam>
        Create Nearby Set
    </button>


    </div>
  <div class="col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">Nearby Sets</div>
        <div class="panel-body">
        <?php $counter=0 ?>
            
          @foreach ($nearbySets as $nearbySet)
            <!-- ========== This code is CRAZY ============ -->
            <div class="row" id="nearbySet{{$nearbySetsID[$counter]->id}}">
            
            <?php $nearbyset='' ?>
            @foreach ($nearbySet as $char)
              <?php $nearbyset = $nearbyset . $char; ?> 
            @endforeach 
            <?php $nearbys = explode(",", $nearbyset); ?>
            <!-- ========== This code is CRAZY ============ -->
            @foreach ($nearbys as $nearby)
              @foreach ($patrons as $patron)
                @if ($nearby == $patron->id) 
                  <div class="col-md-2">
                  <img src="{{$patron->picurl}}" class="img-thumbnail" alt="patronPic">
                  <p>{{$patron->name}}</p>
                  </div>
                @endif
              @endforeach
            @endforeach
            <button type="button" class="btn btn-danger pull-right deleteSet" id="deleteSet{{$nearbySetsID[$counter]->id}}">Delete Set</button>
            <?php $counter++ ?>
            </div>
          @endforeach
        </div>
    </div><!-- close Panel-->
  </div>
  <div class="col-md-2"></div>
</div>

<script>
$( document ).ready(function() {
  $('#newNearbySet').on('click', function (e) {
    var tempURL = '';
    var counter = 0;
      if ($('.patronCheckBox:checkbox:checked').length > 4){
        alert('Max of 4 Patrons per set')
        return;
      }else{
        $('.patronCheckBox:checkbox:checked').each(function() {
          tempURL = tempURL + this.id.substring(6) + "-";
        });
        tempURL = tempURL.substring(0, tempURL.length - 1);
        window.location.href = "/createNearbySet/"+tempURL;
      }
  });

  $('.deleteSet').on('click', function (e) {
    var $this = $(this);
    var setID = $this.attr("id").substring(9);
    $.get( "/deleteNearbySet/"+setID, function( data ) {
        window.location.reload(1);
    });
  });
});


</script>
@endsection