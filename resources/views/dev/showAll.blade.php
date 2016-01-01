@extends('app')

@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css"/>
     
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-inverse">
            <div class="panel-heading">Event List</div>
            <div class="panel-body">
                <table id="datatable" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Event Name</th>
                            <th>Date/Time of Event</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $event)
                            <tr>
                                <td>{{$event->id}}</td>
                                <td><a href="{{ url('/event/'.$event->id) }}">{{$event->name}}</a></td>
                                <td class="datetime">{{$event->datetime}}</td>
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
        $('.datetime').each(function(){
            var timeStamp = new Date($(this).html());
            var year = timeStamp.getFullYear();
            var month = timeStamp.getMonth()+1;
            var date = timeStamp.getDate();
            var hour = timeStamp.getHours();
            var min = timeStamp.getMinutes();
            var day = timeStamp.getDay();
            if (day = 1) day = 'Sunday';
            if (day = 2) day = 'Monday';
            if (day = 3) day = 'Tuesday';
            if (day = 4) day = 'Wednesday';
            if (day = 5) day = 'Thursday';
            if (day = 6) day = 'Friday';
            if (day = 7) day = 'Saturday';
            var ampm = 'am';
            if (hour > 12){ 
                hour = hour-12;
                ampm = 'pm';
            }
            $(this).html(date+'-'+month+'-'+year+' | '+hour+":"+min+ampm+" | "+day);
        });
    });
</script>

@endsection