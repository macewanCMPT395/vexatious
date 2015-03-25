@extends('layouts.admin')
@section('headerScript')
{{ HTML::style('css/kits.css') }}
{{ HTML::style('css/shipping.css') }}
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
@stop
@section('shippingli') class="active" @stop
@section('content')

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
<table id="todayBookings" class="bookingsTable bookingRows">
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
<table id="tomorrowBookings" class="bookingsTable bookingRows">
<tbody>
</tbody>
</table>
</div>
</div>

<script>
//Set Table Dates
var todayTitle = document.querySelector("#todayDate");
var tomorrowTitle = document.querySelector("#tomorrowDate");
    
todayTitle.innerHTML = moment().format("dddd, MMMM Do YYYY");
tomorrowTitle.innerHTML = moment(today).add(1,'days').format("dddd, MMMM Do YYYY");
    
//Add Rows to table

    
var shippingToday = [],
    shippingTomorrow = [];
var bookings = {{ json_encode($bookings['bookings']); }};
for (var i = 0; i < bookings.length; i++) {
    var shippingDate = new Date(bookings[i].shipping * 1000);
    var today = new Date(moment());
    var tomorrow = new Date(moment(today).add(1,'days'));
    console.log(bookings[i]);
    if (datesEqual(today,shippingDate))
         shippingTomorrow.unshift(bookings[i]);
    if (datesEqual(tomorrow,shippingDate))
         shippingToday.unshift(bookings[i]);
}

if (shippingToday.length == 0)
    addRow("todayBookings", "Nothing to Ship", "", "");
else {   
    for (var i = 0; i < shippingToday.length; i++) {
        var b = shippingToday[i];
        addRow("todayBookings", b.description, b.barcode,b.destination);
    }
}

if (shippingTomorrow.length == 0)
    addRow("tomorrowBookings", "Nothing to Ship", "", "");
else {
    for (var i = 0; i < shippingTomorrow.length; i++) {
        var b = shippingTomorrow[i];
        addRow("tomorrowBookings", b.description, b.barcode,b.destination);
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
