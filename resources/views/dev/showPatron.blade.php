@extends('app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"/>
     
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Patron Detail - {{$patron->name}}</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/editPatron/'.$patron->id) }}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">

                  <div class="form-group">
                    <label class="col-md-4 control-label">Full Name</label>
                    <div class="col-md-6">
                      <input type="name" class="form-control" name="name" value="{{$patron->name}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-4 control-label">URL of Fb Pic</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="picurl" value="{{$patron->picurl}}">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="col-md-4 control-label">Address</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="address" value="{{$patron->address}}">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="col-md-4 control-label">Suburb/city</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="suburb" value="{{$patron->suburb}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-4 control-label">Nearby</label>
                    <div class="col-md-6">
                      <select class="form-control" id="sel1" name="nearby">
                          <option>null</option>
                        @foreach ($patrons as $patron1) 
                          <option  @if($patron1->name == $patron->nearby) selected @endif>{{$patron1->name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                      <button type="submit" class="btn btn-primary">Save Patron</button>
                    </div>
                  </div>
                </form>

            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>


@endsection