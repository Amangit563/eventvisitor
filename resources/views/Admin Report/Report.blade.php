@extends('Layout.layout')
@section('title','Visitor Ticket Report')
@section('content')

<div class="heading">
    <h4 class="mt-3">Visitors Report</h4>
</div>
<div class="row mt-4 table-responsive">
    <table id="exampleTable" class="table table-hover table-responsive" style="width:100%">
        <thead>
            <tr>
                <th>User_ID</th>
                <th>Ticket_ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Device_NO</th>
                <th>Designation</th>
                <th>Company_Name</th>
                <th>Company_Location</th>
                <th>Event_Name</th>
                <th>Event_Location</th>
                <th>Date</th>
                <th>Time</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->user_id }}</td>
                    <td>{{ $ticket->ticket_id }}</td>
                    <td>{{ $ticket->name }}</td>
                    <td>{{ $ticket->phone }}</td>
                    <td>{{ $ticket->email }}</td>
                    <td>{{ $ticket->device_no }}</td>
                    <td>{{ $ticket->designation }}</td>
                    <td>{{ $ticket->company_name }}</td>
                    <td>{{ $ticket->company_location }}</td>
                    <td>{{ $ticket->event_name }}</td>
                    <td>{{ $ticket->event_location }}</td>
                    <td>{{ $ticket->date }}</td>
                    <td>{{ $ticket->time }}</td>
                    <td>{{ $ticket->created_at }}</td>
                    <td>{{ $ticket->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


@endsection
