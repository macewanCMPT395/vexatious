@extends('layouts.header')
@section('headerScript')
{{ HTML::style('css/tableFilter.css') }}
{{ HTML::style('css/shipping.css') }}
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::script('fullcalendar/lib/moment.min.js') }}
@stop
@section('shippingli') class="active" @stop
@section('content')
<ul class="TableFilter-Bar">
	{{ Form::open(['method' => 'put', 'route' => 'bookings.update']) }}
	<li>
	{{ Form::label('branch', 'Shipping from') }}
	{{ Form::select('branch', Branch::lists('name', 'id')); }}
	</li>
	<li>
	{{ Form::hidden('form', 'ship') }} {{ Form::hidden('id', '') }} {{ Form::hidden('shipped', '') }} {{ Form::hidden('received', '') }}
	{{ Form::submit('Ship') }}
	</li>
	{{Form::close() }}
</ul>


<table class="layout">
	<!--Branch selector and ship button-->
	<tr>
	<!--Next row tables-->
	<td class="innerTable">
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
				<table id="todayBookings" class="bookingsTable bookingRows">
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</td>
		
	<td class="innerTable">
		<div id="tomorrowTable">
			<div class="tableTitle">Tomorrow </div>
			<div id="tomorrowDate"> [Tomorrow's Date] </div>
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
				<table id="tomorrowBookings" class="bookingsTable bookingRows">
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</td>
</table>
<ul class="navMenu footer">
  <li>
	<a href="#" id="createBooking">Ship Kit</a>
  </li>
</ul> 


<script>
//Set Table Dates
var todayTitle = document.querySelector("#todayDate");
var tomorrowTitle = document.querySelector("#tomorrowDate");
    
var today = new Date(moment());
var tomorrow = new Date(moment(today).add(1,'days'));
    
todayTitle.innerHTML = moment().format("dddd, MMMM Do YYYY");
tomorrowTitle.innerHTML = moment(today).add(1,'days').format("dddd, MMMM Do YYYY");
    
var selected;
    
//Add Rows to table  
var typeList = {{ json_encode(HardwareType::lists('name', 'id')) }};
var branchList = {{ json_encode(Branch::lists('name', 'id')) }};
var allBookings = {{ json_encode($bookings['bookings']); }};
var bookings;
updateTables();
    
$('#branch').change(updateTables);
function updateTables() {
    //Filter bookings
    bookings = allBookings.filter(function(a) { 
        return a.currentBranchID == $('#branch').val(); });
    console.log(bookings);
    clearTable("todayBookings");
    clearTable("tomorrowBookings");
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
        var start = new Date(bookings[i].start * 1000);
        console.log(start + " " +  shippingDate);
        //IF booking is due to be shipped today or is late
        if ((datesEqual(today,shippingDate) || 
            (shippingDate < today)) && (bookings[i].shipped == "0"))
             shippingToday.unshift(bookings[i]);
		
        if (datesEqual(tomorrow,shippingDate) && (bookings[i].shipped == "0"))
             shippingTomorrow.unshift(bookings[i]);
    }

    if (shippingToday.length == 0)
        addRow("todayBookings", null);
    else {   
        for (var i = 0; i < shippingToday.length; i++) {
            var b = shippingToday[i];
            addRow("todayBookings", b);
        }
    }

    if (shippingTomorrow.length == 0)
        addRow("tomorrowBookings", null);
    else {
        for (var i = 0; i < shippingTomorrow.length; i++) {
            var b = shippingTomorrow[i];
            addRow("tomorrowBookings", b);
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
    console.log(b);
    if (b == null)
        row.insertCell(0).innerHTML= "Nothing to Ship";
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
                document.getElementsByName("received")[0].value = 0;
            } else {
                document.getElementsByName("id")[0].value = "";
                document.getElementsByName("shipped")[0].value = "";
                document.getElementsByName("received")[0].value = "";
                
            }
        }
}

</script>
@stop
