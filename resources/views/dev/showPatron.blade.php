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
                      <select class="form-control" name="suburb">
                          <option @if($patron->suburb == 'stlucia') selected @endif>St Lucia</option>
                          <option @if($patron->suburb == 'toowong') selected @endif>Toowong</option>
                          <option @if($patron->suburb == 'taringa') selected @endif>Taringa</option>
                          <option @if($patron->suburb == 'auchenflower') selected @endif>Auchenflower</option>
                          <option @if($patron->suburb == 'indooroopilly') selected @endif>Indooroopilly</option>
                          <option @if($patron->suburb == 'chapelhill') selected @endif>Chapelhill</option>
                          <option @if($patron->suburb == 'kelvingrove') selected @endif>Kelvingrove</option>
                          <option @if($patron->suburb == 'woolongabba') selected @endif>Woolongabba</option>
                          <option @if($patron->suburb == 'duttonpark') selected @endif>Duttonpark</option>
                          <option @if($patron->suburb == 'fairfield') selected @endif>Fairfield</option>
                          <option @if($patron->suburb == 'oxley') selected @endif>oxley</option>
                          <option @if($patron->suburb == 'sherwood') selected @endif>Sherwood</option>
                          <option @if($patron->suburb == 'corinda') selected @endif>Corinda</option>
                          <option @if($patron->suburb == 'sunnybank') selected @endif>Sunnybank</option>
                          <option @if($patron->suburb == 'willawong') selected @endif>Willawong</option>
                          <option @if($patron->suburb == 'logan') selected @endif>Logan</option>
                          <option @if($patron->suburb == 'other') selected @endif>Other</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-4 control-label">Post Code</label>
                    <div class="col-md-6">
                      <input type="text" class="form-control" name="postcode" value="{{$patron->postcode}}">
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