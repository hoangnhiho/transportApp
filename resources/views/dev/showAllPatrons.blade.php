@extends('app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"/>
     
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Patron List</div>
            <div class="panel-body">
                <table id="datatable" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Patron ID</th>
                            <th>Patron Name</th>
                            <th>Patron Address/th>
                            <th>Patron Suburb</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patrons as $patron)
                            <tr>
                                <td>{{$patron->id}}</td>
                                <td><a href="{{ url('/patron/'.$patron->id) }}">{{$patron->name}}</a></td>
                                <td>{{$patron->address}}</td>
                                <td>{{$patron->suburb}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>




<script type="text/javascript" src="https://cdn.datatables.net/s/dt/jq-2.1.4,dt-1.10.10,af-2.1.0/datatables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable();
    });
</script>

@endsection