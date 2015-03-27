@extends('layouts.header')
@section('headerScript')
{{ HTML::style('css/calendar.css') }}
{{ HTML::style('css/bookkit.css') }}
<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.js'></script>
<script type='text/javascript' src='fullcalendar/gcal.js'></script>
<script type='text/javascript' src='lightbox.js'></script>
<script> 

$('td.fc-day-number').mouseover(function ()
{
var strDate = $(this).data('date');
$("td.fc-day").filter("[data-date='" + strDate + "']").addClass('fc-highlight')
});

var selectedDay;
var currentDate = new Date();
currentDate = currentDate.getUTCDate() + "-" + (currentDate.getMonth() + 1) + "-" + currentDate.getFullYear();
var date = new Date();
var endDate = new Date(date.getFullYear(), date.getMonth() + 1, 0);
endDate = endDate.getUTCDate() + "-" + (endDate.getMonth() + 1) + "-" + endDate.getFullYear();
$(document).ready(function() {
	
	var userName = "{{ Auth::user()->firstName.' '.Auth::user()->lastName; }}";
	
	
	
	//add "All" to type filter
	$('#type').prepend('<option value="0">All</option>');
	//add "Mine" to branch filter
	$('#branch').prepend('<option value="0">' + userName + '</option>');
	
	//LOAD Bookings into events array
	var bookings = {{ json_encode($bookings['bookings']); }};
				  
				  
	function filterBookings() {
		//first, only grab the bookings for the current branch
		var filterEvents = bookings.filter(function(a) {
			
			var branchAdd = ($('#branch').val() == 0 || a.destination == $('#branch').val());
			if ($('#type').val() == 0) {
				return branchAdd;
			} else {
				return branchAdd &&
					a.type == $('#type').val();
			}
		});

		var newEvents = filterEvents.map(function(e) {
			return {
				title: e.eventName,
				start: new Date(e.start* 1000),
				end: new Date(e.end * 1000),
				tip: 'Destination: ' + e.name,
				color: '#7CC045',
				allDay: false 
			};
		});
	
		return newEvents;
	}
	
	function updateFilters() {
		//update events
		(function(e) {
			$('#calendar').fullCalendar('removeEvents');
			console.log(e);
			$('#calendar').fullCalendar('addEventSource', e);
			$('#calendar').fullCalendar('refetchEvents');
		})(filterBookings());	
	}

    $('#calendar').fullCalendar({
        header: {
            left: ' title',
            center: '',
            right: 'prev,next today'
        },
        buttonIcons: {
            //prev: 'left-single-arrow',
            //next: 'right-single-arrow'
        },
        //theme: true,
        contentHeight: 600,
        //defaultDate: '2015-04-12',
        editable: false,
        eventLimit: true, // allow "more" link when too many events
        events: filterBookings(),
        eventRender: function(event, element) {
			$(element).find(".fc-time").hide();
            element.attr('title', event.tip);
        },
        dayClick: function(date, jsEvent, view) {
            //CHECK if day can be selected
            //Must not be in the past, 
            //Must have kits available
            selectDay($(this));
            
            //Auto-Fill Date Fields
            var start = document.getElementById('startField'),
                end = document.getElementById('endField');
            start.value = end.value = date.format();
			
        }
    });
	
	//update calender with appropriate filters
	$('#branch').change(updateFilters);
	$('#type').change(updateFilters);
	
	//sample accessing certain days on the calendar
	//$(".fc-day[data-date='2015-03-01']").css('background-color', '#AAAAAA');
});
    
function selectDay(day){
    if (selectedDay != null)
        selectedDay.css('background-color', 'white');
    selectedDay = day;
    selectedDay.css('background-color', '#FBBC2E');
}
    
function parseDate(date) {
   /* var day = date.substring(0,2);
    //Decrement Month to convert to month system starting with 0
    var month = date.substring(3,5) - 1; 
    var year = date.substring(6,10);*/
	
	return date;
    
    return new Date(year, month, day);
}
</script>
@stop
@section('overviewli') class="active" @stop
@section('content')
<div class="content">
<div class="bookKitForm">
    {{ Form::open(['method' => 'get', 'route' => 'kits.index']) }}
    <div class="title"></div>
    <ul class="formFields">
    <li>
    {{ Form::label('branch', 'Bookings For') }}
	{{ Form::select('branch', Branch::lists('name', 'id')); }}
    </li>
    <li>
    {{ Form::label('type', 'Type') }}
	{{ Form::select('type', HardwareType::lists('name', 'id')) }}
	{{Form::close() }}
    </li>
</ul>
<div class="tabs">
    <ul class="tabs">
        <li>
          <input type="radio" checked name="tabs" id="tab1">
          <div id="tab-content1" class="tab-content animated fadeIn">
              <div id="calendar"></div>
          </div>
        </li>

</div>
</div>

<script>


</script>
@stop