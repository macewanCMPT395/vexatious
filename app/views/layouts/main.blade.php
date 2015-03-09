<!doctype html>
<html lang="en">
<body>
    {{ HTML::style('css/main.css') }}
<div id="Image"><img src="http://www.epl.ca/sites/all/themes/epl/img/epl_logo.jpg" border="0"></div>
<div id="bar"></div>
<div class="button" id="home"><a href= {{URL::home()}}>HOME</div>
<div class="button" id="reportdamage"><a href= {{URL::route('reportdamage')}}>REPORT DAMAGE</div>
<div class="button" id="browsekits"><a href= {{URL::route('browsekits')}}>BROWSE KITS</div>
</body>
</html>
