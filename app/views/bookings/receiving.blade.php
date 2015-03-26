@extends('layouts.admin')
@section('headerScript')
{{ HTML::style('css/kits.css') }}
{{ HTML::style('css/shipping.css') }}
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
@stop
@section('receivingli') class="active" @stop
@section('content')
<div class="form">
<ul class="formFields">
    <li>
    {{ Form::label('branch', 'Receiving at') }}
	{{ Form::select('branch', Branch::lists('name', 'id')); }}
    {{Form::close() }}
    </li>
</ul>
</div>
<div id="todayTable">
<div class="tableTitle">Today </div>
<div id="todayDate"> [Today's Date] </div>
<table class="bookingsTable">
<thead>
<tr>
    <th>Description</th>
    <th>Barcode</th>
    <th>Destination Branch ID</th>
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

<div id="tomorrowTable">
<div class="tableTitle">Tomorrow </div>
<div id="tomorrowDate"> [Tomorrow's Date] </div>
<table class="bookingsTable">
<thead>
<tr>
    <th>Description</th>
    <th>Barcode</th>
    <th>Destination Branch ID</th>
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

<script>
//Set Table Dates
var todayTitle = document.querySelector("#todayDate");
var tomorrowTitle = document.querySelector("#tomorrowDate");
    
var today = new Date(moment());
var tomorrow = new Date(moment(today).add(1,'days'));
    
todayTitle.innerHTML = moment().format("dddd, MMMM Do YYYY");
tomorrowTitle.innerHTML = moment(today).add(1,'days').format("dddd, MMMM Do YYYY");
    
//Add Rows to table    
var allBookings = {{ json_encode($bookings['bookings']); }};
    
//Filter Bookings
var bookings = allBookings.filter(function(a) {
    return a.destination == $('#branch').val();
});
    
updateTables();
    
$('#branch').change(updateTables);

function updateTables() {
    bookings = allBookings.filter(function(a) { 
        return a.currentBranchID == $('#branch').val(); });
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
        if ((bookings[i].received == 0) && (bookings[i].shipped == 1))
        //IF a booking is expected tomorrow
        if (datesEqual(tomorrow,shippingDate))
             shippingToday.unshift(bookings[i]);
    }

    if (shippingToday.length == 0)
        addRow("receiveToday", "Nothing to Receive", "", "");
    else {   
        for (var i = 0; i < shippingToday.length; i++) {
            var b = shippingToday[i];
            addRow("receiveToday", b.description, b.barcode,b.destination);
        }
    }

    if (shippingTomorrow.length == 0)
        addRow("receiveTomorrow", "Nothing to Receive", "", "");
    else {
        for (var i = 0; i < shippingTomorrow.length; i++) {
            var b = shippingTomorrow[i];
            addRow("receiveTomorrow", b.description, b.barcode,b.destination);
        }
    }

    //Make Table Rows selectable
    var rows = document.querySelectorAll(".bookingRows tbody tr");
    var selected;
    for(var i = 0; i < rows.length; i++) {
        rows[i].onclick = function() {
            if (selected != null)
                selected.classList.toggle('selected');
            selected = this;
            selected.classList.toggle('selected');
        }
    }
}
    
function datesEqual(a,b) {
    return ((a.getMonth() == b.getMonth()) && 
            (a.getFullYear() == b.getFullYear()) && 
            (a.getDate() == b.getDate()));
}

function addRow(tableID, description, barcode, destinationID) {
    
    var table = document.getElementById(tableID);

    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);

    row.insertCell(0).innerHTML= description;
    row.insertCell(1).innerHTML= barcode;
    row.insertCell(2).innerHTML= destinationID;
    
    row.className += " row";
}

</script>
@stop
