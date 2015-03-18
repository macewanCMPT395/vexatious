<!doctype html>
<html lang="en">
<head>
    {{ HTML::style('css/calendar.css') }}
    <link rel='stylesheet' href='fullcalendar/fullcalendar.css' />
    <script src='fullcalendar/lib/jquery.min.js'></script>
    <script src='fullcalendar/lib/moment.min.js'></script>
    <script src='fullcalendar/fullcalendar.js'></script>
    <script type='text/javascript' src='fullcalendar/gcal.js'></script>
    
    @yield('calendarScript')
    
   
</head>

<body> 
<div class="header-fixed">
<div class="title"> &nbsp&nbsp{{ link_to("/", "Tree Branch") }} </div>
<div class="bar"></div>
</div>
<div class="content">
    @yield('content')
</div>
</body>

</html>