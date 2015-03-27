@extends('layouts.admin')
@section('headerScript')
{{ HTML::style('css/shipping.css') }}
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
@stop
@section('receivingli') class="active" @stop
@section('content')

<table class="layout">
<tr>
<td colspan="2">
<div class="form">
{{ Form::open(['method' => 'put', 'route' => 'bookings.update']) }}
<ul class="formFields">
    <li>
    {{ Form::label('branch', 'Receiving at') }}
	{{ Form::select('branch', Branch::lists('name', 'id')); }}
    </li>
    <li id="submit">
    {{ Form::hidden('form', 'received') }}
    {{ Form::hidden('id', '') }}
    {{ Form::hidden('shipped', '') }}
    {{ Form::hidden('received', '') }}
    {{ Form::hidden('kitID', '') }}  
    {{ Form::hidden('destination', '') }}
    {{ Form::submit('Received') }}
    </li>
</ul>
{{Form::close() }}
</div>
</td>
</tr>
<tr>
<td>
<div id="todayTable">
<div class="tableTitle">Today </div>
<div id="todayDate"> [Today's Date] </div>
<table class="bookingsTable">
<thead>
<tr>
    <th>Description</th>
    <th>Barcode</th>
    <th>Destination Branch</th>
</tr>
</thead>
</table>
<div class="tableRows">
<table id="receiveToday" class="bookingsTable bookingRows">
<tbody>
</tbody>
</table>
</div>
</div>
</td>
<td>
<div id="tomorrowTable">
<div class="tableTitle">Tomorrow </div>
<div id="tomorrowDate"> [Tomorrow's Date] </div>
<table class="bookingsTable">
<thead>
<tr>
    <th>Description</th>
    <th>Barcode</td>
    <th>Destination Branch</th>
</tr>
</thead>
</table>
<div class="tableRows">
<table id="receiveTomorrow" class="bookingsTable bookingRows">
<tbody>
</tbody>
</table>
</div>
</div>
</td></tr>
</table>
<script>
//Set Table Dates
var todayTitle = document.querySelector("#todayDate");
var tomorrowTitle = document.querySelector("#tomorrowDate");
    
var today = new Date(moment());
var tomorrow = new Date(moment(today).add(1,'days'));
    
var selected;
    
todayTitle.innerHTML = moment().format("dddd, MMMM Do YYYY");
tomorrowTitle.innerHTML = moment(today).add(1,'days').format("dddd, MMMM Do YYYY");
    
//Add Rows to table  
var branchList = {{ json_encode(Branch::lists('name', 'id')) }};
var allBookings = {{ json_encode($bookings['bookings']); }};
    
//Filter Bookings
var bookings = allBookings.filter(function(a) {
    return a.destination == $('#branch').val();
});
    
updateTables();
    
$('#branch').change(updateTables);

function updateTables() {
    bookings = allBookings.filter(function(a) { 
        return a.destination == $('#branch').val(); });
	
    clearTable("receiveToday");
    clearTable("receiveTomorrow");
    populateTables();
}
    
function clearTable(tableID) {
    var numRows = document.getElementById(tableID).rows.length;
    for (var i = 0; i < numRows; i++) {
        document.getElementById(tableID).deleteRow(i);
    }
}
    
function populateTables() {
    var shippingToday = [],
        shippingTomorrow = [];
    
    for (var i = 0; i < bookings.length; i++) {
        var shippingDate = new Date(bookings[i].shipping * 1000);
        //IF a booking is shipped but not received
        //if ((bookings[i].received == 0) && (bookings[i].shipped == 1))
        shippingToday.unshift(bookings[i]);
        //IF a booking is expected tomorrow
        if (datesEqual(tomorrow,shippingDate) && 
            (bookings[i].shipped == 0))
             shippingTomorrow.unshift(bookings[i]);
    }

    if (shippingToday.length == 0)
        addRow("receiveToday", null);
    else {   
        for (var i = 0; i < shippingToday.length; i++) {
            var b = shippingToday[i];
            addRow("receiveToday", b);
        }
    }

    if (shippingTomorrow.length == 0)
        addRow("receiveTomorrow", null);
    else {
        for (var i = 0; i < shippingTomorrow.length; i++) {
            var b = shippingTomorrow[i];
            addRow("receiveTomorrow", b);
        }
    }
}
    
function datesEqual(a,b) {
    return ((a.getMonth() == b.getMonth()) && 
            (a.getFullYear() == b.getFullYear()) && 
            (a.getDate() == b.getDate()));
}

function addRow(tableID, b) {
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    if (b == null)
        row.insertCell(0).innerHTML= "Nothing to Receive";
    else {
        row.insertCell(0).innerHTML= b.description;
        row.insertCell(1).innerHTML= b.barcode;
        row.insertCell(2).innerHTML= branchList[b.destination];
    }
    row.className += " row";
    
    //Make row selectable
    row.onclick = function() {
            if (selected != null)
                selected.classList.toggle('selected');
            selected = this;
            selected.classList.toggle('selected');
            if (b != null) {
                document.getElementsByName("id")[0].value = b.bookingID;
                document.getElementsByName("shipped")[0].value = 1;
                document.getElementsByName("received")[0].value = 1;
                document.getElementsByName("kitID")[0].value = b.kitID;
                document.getElementsByName("destination")[0].value = b.destination;
            } else {
                document.getElementsByName("id")[0].value = "";
                document.getElementsByName("shipped")[0].value = "";
                document.getElementsByName("received")[0].value = "";
                document.getElementsByName("kitID")[0].value = "";
                document.getElementsByName("destination")[0].value = "";
            }
        }
}

</script>
@stop
