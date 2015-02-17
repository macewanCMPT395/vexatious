<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Calendar</title>
{{ HTML::style('css/main.css') }}
<link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/fullcalendar.js'></script>
<script type='text/javascript' src='fullcalendar/gcal.js'></script>
<script> 
$(document).ready(function() {

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        defaultDate: '2015-02-12',
        editable: true,
        eventLimit: true, // allow "more" link when too many events
        //link to Karo's Google cal for demo purposes
        googleCalendarApiKey: 'AIzaSyDc-WMAzUIMZIBeiNXllaRZC_tWLUuNZiU',
        events: {
            googleCalendarId: 'karoantonio@gmail.com'
        }
    });
});
</script>
</head>
<body>
	<h1>Kit MGMT</h1>
    <div id='calendar'></div>
</body>
</html>
