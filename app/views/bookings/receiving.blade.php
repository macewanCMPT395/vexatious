@extends('layouts.admin')
@section('headerScript')
{{ HTML::style('css/tableList.css') }}
{{ HTML::style('css/shipping.css') }}
{{ HTML::style('css/tableFilter.css') }}
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::script('fullcalendar/lib/moment.min.js') }}

@stop
@section('receivingli') class="active" @stop
@section('content')
<ul class="TableFilter-Bar">
	{{ Form::open(['method' => 'put', 'route' => 'bookings.update']) }}
	<li>
	{{ Form::label('branch', 'Receiving at') }}
	{{ Form::select('branch', Branch::lists('name', 'id')); }}
	</li>
	<li>
	{{ Form::hidden('form', 'received') }}
	{{ Form::hidden('id', '') }}
	{{ Form::hidden('shipped', '') }}
	{{ Form::hidden('received', '') }}
	{{ Form::hidden('kitID', '') }}  
	{{ Form::hidden('destination', '') }}
	{{ Form::submit('Received') }}
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
	<a href="#" id="createBooking">Received Kit</a>
  </li>
</ul> 

<script>
//Set Table Dates
var todayTitle = document.querySelector("#todayDate");
var tomorrowTitle = document.querySelector("#tomorrowDate");
    
var today = new Date(moment());
var tomorrow = new Date(moment(today).add(1,'days'));

$(".navMenu.footer").css('bottom','-10%');
    
todayTitle.innerHTML = moment().format("dddd, MMMM Do YYYY");
tomorrowTitle.innerHTML = moment(today).add(1,'days').format("dddd, MMMM Do YYYY");
    
//Add Rows to table  
var branchList = {{ json_encode(Branch::lists('name', 'id')) }};
var allBookings = {{ json_encode($bookings['bookings']); }};
var todaysBookings;
var tomorrowsBookings;

//Set the headers for both tables
$('.table-static-header-row')
       .append($('<td></td>').text('BarCode'))
       .append($('<td></td>').text('Type'))
       .append($('<td></td>').text('Destination'));

updateTables();
    
$('#branch').change(updateTables);

function updateTables() {
    getShipping();
    populateTables();
}

function getShipping() {
         var currentBranch = $('#branch').val();
         todaysBookings = allBookings.filter(function(a) {
                  return (a.destination == currentBranch); });

        tomorrowsBookings = allBookings.filter(function(a) {
                  return (a.destination == currentBranch); });
}
    
function populateTables() {
    var todaysTable = $('#todayTable .table-rows-table');
    var tomorrowsTable = $('#tomorrowTable .table-rows-table');
    todaysTable.empty();
    tomorrowsTable.empty();
    if (todaysBookings.length == 0) {
       var row = document.createElement('tr');
                        $(row).append($('<td></td>').text("No Kits Coming In"));
                        todaysTable.append($(row));
    } else {
    todaysBookings.forEach(function(booking) {
             var row = document.createElement('tr');
             $(row).append($('<td></td>').text(booking.start));
             $(row).attr('id',booking.id);
	     todaysTable.append($(row));
	     
	todaysTable.on('click', '#'+booking.id, function() {
                                $('.selected').each(function() {
                                   $(this).removeClass('selected');
                                });
                                $(this).addClass('selected');
                                $(".navMenu.footer").animate({bottom:"2%"}, 400, function(){});
                                });

             });
    }

    if (tomorrowsBookings.length == 0) {
       var row = document.createElement('tr');
                        $(row).append($('<td></td>').text("No Kits To Coming In"));
                        tomorrowsTable.append($(row));
    } else {
    tomorrowsBookings.forEach(function(booking) {
             var row = document.createElement('tr');
             $(row).append($('<td></td>').text(booking.start));
             $(row).attr('id',booking.id);
	     tomorrowsTable.append($(row));
             
	tomorrowsTable.on('click', '#'+booking.id, function() {
                                $('.selected').each(function() {
                                   $(this).removeClass('selected');
                                });
                                $(this).addClass('selected');
                                $(".navMenu.footer").animate({bottom:"2%"}, 400, function(){});
                                });
     
	     });
    }
}
    
function datesEqual(a,b) {
    return ((a.getMonth() == b.getMonth()) && 
            (a.getFullYear() == b.getFullYear()) && 
            (a.getDate() == b.getDate()));
}

</script>
@stop
