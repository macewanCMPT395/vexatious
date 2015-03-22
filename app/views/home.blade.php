@extends('layouts.admin')

@section('headerScript')
{{ HTML::style('css/calendar.css') }}
<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.js'></script>
<script type='text/javascript' src='fullcalendar/gcal.js'></script>
<script> 
    
var bookings = <?php echo json_encode($bookings); ?>;

var eventsArray = [];
    
console.log(bookings[0])

//LOAD Bookings into events array
for (var i = 0; i < bookings.length; i++) {
    eventsArray.unshift({
        title: bookings[i].eventName,
        start: parseDate(bookings[i].start),
        end: parseDate(bookings[i].end),
        tip: 'Destination: ' + bookings[i].destination,
        color: '#7CC045',
        allDay: true    
        });
}

eventsArray.unshift({
        title: 'iPad #388',
        start: new Date(2015, 2, 20),
        end: new Date(2015, 2, 25),
        tip: 'Personal tip 1',
        color: '#7CC045',
        allDay: true    
        });
  /*  
var eventsArray = [
        {
        title: 'iPad #388',
        start: new Date(2015, 2, 20),
        end: new Date(2015, 2, 25),
        tip: 'Personal tip 1',
        color: '#7CC045',
        allDay: true    
        },
        {
        title: 'MacBook #400',
        start: new Date(2015, 2, 20),
        end: new Date(2015, 2, 24),
        tip: 'Personal tip 1',
        color: '#E00F63',
        allDay: true 
        },
        {
        title: 'iPod #388',
        start: new Date(2015, 2, 20),
        end: new Date(2015, 2, 22),
        tip: 'Personal tip 1',
        color: '#039CE0',
        allDay: true 
        },
        {
        title: 'Zunes #None',
        start: new Date(2015, 2, 3),
        tip: 'Personal tip 2',
        color: '#7B4196',
        allDay: true 
        }
    ];
*/
    
$(document).ready(function() {
    
    
    

    $('#calendar').fullCalendar({
        header: {
            left: 'title',
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
        events: eventsArray,
        eventRender: function(event, element) {
            element.attr('title', event.tip);
        }
    });
});
    
function parseDate(date) {
    var day = date.substring(0,2);
    //Decrement Month to convert to month system starting with 0
    var month = date.substring(3,5) - 1; 
    var year = date.substring(6,10);
    
    return new Date(year, month, day);
}
</script>


@stop
@section('content')
<div class="content">
<div class="tabs">
    <ul class="tabs">
        <li>
          <input type="radio" checked name="tabs" id="tab1">
          <div id="tab-content1" class="tab-content animated fadeIn">
              <div id="calendar"></div>
          </div>
        </li>
</ul>
</div>
</div>

@stop