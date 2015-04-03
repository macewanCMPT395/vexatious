@extends('layouts.header')
@section('headerScript')
{{ HTML::style('css/tableFilter.css') }}
{{ HTML::style('css/tableList.css') }}
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
<div>	
     <div id="todayTable">
	<div class="tableTitle">Today </div>
     	<div id="todayDate"> [Today's Date] </div>
     	<div>
     	     @include('layouts.tableList')
     	     </div>
     </div>
     <div id="tomorrowTable">
	<div class="tableTitle">Tomorrow </div>
	<div id="tomorrowDate"> [Tomorrow's Date] </div>
	<div>
	     @include('layouts.tableList')
	</div>
	</div>
</div>

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

//Set the headers for both tables
      $('.table-static-header-row')
		.append($('<td></td>').text('BarCode'))
		.append($('<td></td>').text('Type'))
		.append($('<td></td>').text('Destination'));
    
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
    populateTables();
} 
        
function populateTables() {
    var table = $('.todayTable');
    table.empty();
    bookings.forEach(function() {
    	     var row = document.createElement('tr');
	     $(row).append($('<td></td>').text(bookings.start));
	     table.append($(row));
	     });
	     table.append($('<tr><td></td></tr>').text("This is working")); 
}

function datesEqual(a,b) {
    return ((a.getMonth() == b.getMonth()) && 
            (a.getFullYear() == b.getFullYear()) && 
            (a.getDate() == b.getDate()));
}
    
</script>
@stop
