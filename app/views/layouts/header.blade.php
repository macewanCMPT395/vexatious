<!doctype html>
<html lang="en">
<body>
    {{ HTML::style('css/header.css') }}
<div id="Image"><img src="http://www.epl.ca/sites/all/themes/epl/img/epl_logo.jpg" border="0"></div>
<div id="bar"></div>
<div class="button"><a href= {{URL::route('reportdamage')}}>REPORT DAMAGE</div>
<div class="button"><a href= {{URL::route('kits.index')}}>BROWSE KITS</div>
<div class="button"><a href={{URL::route('home')}}>BOOK KIT</div>
@yield('adminButtons')
@yield('content')
</body>
</html>
