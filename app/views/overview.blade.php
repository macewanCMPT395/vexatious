@extends('layouts.calendar')

@section('calendarScript')
<script> 
$(document).ready(function() {
    var eventsArray = [
        {
        title: 'iPad #388',
        start: new Date(2015, 2, 20),
        end: new Date(2015, 2, 25),
        tip: 'Personal tip 1',
        color: '#E00F63',
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
        color: '#039CE0',
        allDay: true 
        }
    ];

    $('#calendar').fullCalendar({
        editable: true,
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
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        events: eventsArray,
        eventRender: function(event, element) {
            element.attr('title', event.tip);
        }
    });
});
</script>


@stop
@section('content')
<div class="tabs">
    <ul class="tabs">
        <li>
          <input type="radio" checked name="tabs" id="tab1">
          <label for="tab1">Overview</label>
          <div id="tab-content1" class="tab-content animated fadeIn">
              <div id="calendar"></div>
          </div>
        </li>
        <li>
          <input type="radio" name="tabs" id="tab2">
          <label for="tab2">Shipping</label>
          <div id="tab-content2" class="tab-content animated fadeIn">
            Lists of Packages to Ship
          </div>
        </li>
        <li>
          <input type="radio" name="tabs" id="tab3">
          <label for="tab3">Browse Kits</label>
          <div id="tab-content3" class="tab-content animated fadeIn">
            Lots & Lots of Kits
          </div>
        </li>
</ul>
    
</div>

@stop


