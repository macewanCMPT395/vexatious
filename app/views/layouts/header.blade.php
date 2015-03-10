<!doctype html>
<html lang="en">
<body>
    {{ HTML::style('css/header.css') }}
<div id="Image"><img src="http://www.epl.ca/sites/all/themes/epl/img/epl_logo.jpg" border="0"></div>
<div id="bar"></div>
<<<<<<< HEAD
<div class="button"><a href= action('app/controllers/PagesController@showReportDamage')>REPORT DAMAGE</div>
<div class="button"><a href= {{URL::route('browsekits')}}>BROWSE KITS</div>
<div class="button"><a href={{URL::route('home')}}>BOOK KIT</div>
@yield('adminButtons')
@yield('content')
=======
<div class="button" id="home"><a href={{URL::route('home')}}>HOME</div>
<div class="button" id="reportdamage"><a href= {{URL::route('reportdamage')}}>REPORT DAMAGE</div>
<div class="button" id="browsekits"><a href= {{URL::route('browsekits')}}>BROWSE KITS</div>
>>>>>>> ee55699... Finalize header, Add routing to blank pages for all buttons.
</body>
</html>
