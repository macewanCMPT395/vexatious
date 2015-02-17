<!doctype html>
<html lang="en">
<head>
    {{ HTML::style('css/main.css') }}
   
</head>

<body> 
<div class="outer">
<div class="middle">
<div>
<svg width="115" height="105">
<rect x="0" y="0" fill="#FBBC2E" width="15" height="100"/>
<rect x="25" y="0" fill="#7CC045" width="15" height="100"/>
<rect x="50" y="0" fill="#E00F63" width="15" height="100"/>
<rect x="75" y="0" fill="#7B4196" width="15" height="100"/>
<rect x="100" y="0" fill="#039CE0" width="15" height="100"/>
</svg>
</div>
<div class="bar"></div>
    
<div id="title"> &nbsp&nbsp{{ link_to("/", "Kit MGMT") }} </div>
    
<div class="bar"></div>

<div id="nav">
    <ul>
        @yield('items')
        
    </ul>
</div>

</div>
</div>

</body>

</html>