@extends('layouts.admin')
@section('headerScript')
{{ HTML::style('css/kits.css') }}
{{ HTML::style('css/shipping.css') }}
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/lib/moment.min.js'></script>
@stop
@section('shippingli') class="active" @stop
@section('content')


<div id="todayTable">
<div class="tableTitle">Today </div>
<div id="todayDate"> [Today's Date] </div>
<table class="kitsTable">
<thead>
<tr>
    <th>Description</th>
    <th>Barcode</th>
    <th>Destination Branch ID</th>
</tr>
</thead>
</table>
<div class="tableRows">
<table class="kitsTable kitRows">
<tbody>
    @for ($i = 0; $i < 100; $i++) 
        @foreach ($kits as $kit)
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
    @endfor
</tbody>
</table>
</div>
</div>



<div id="tomorrowTable">
<div class="tableTitle">Tomorrow </div>
<div id="tomorrowDate"> [Tomorrow's Date] </div>
<table class="kitsTable">
<thead>
<tr>
    <th>Description</th>
    <th>Barcode</th>
    <th>Destination Branch ID</th>
</tr>
</thead>
</table>
<div class="tableRows">
<table class="kitsTable kitRows">
<tbody>
    @for ($i = 0; $i < 100; $i++) 
        @foreach ($kits as $kit)
        <tr>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
    @endfor
</tbody>
</table>
</div>
</div>

<script>
//Set Table Dates
var today = document.querySelector("#todayDate");
var tomorrow = document.querySelector("#tomorrowDate");

console.log(moment()[0]);
    
today.innerHTML = moment().format("dddd, MMMM Do YYYY");
tomorrow.innerHTML = moment(today).add(1,'days').format("dddd, MMMM Do YYYY");
    
    
//Make Table Rows selectable
var rows = document.querySelectorAll(".kitRows tbody tr");
var selected;
for(var i = 0; i < rows.length; i++) {
    rows[i].onclick = function() {
        if (selected != null)
            selected.classList.toggle('selected');
        selected = this;
        selected.classList.toggle('selected');
    }
}
</script>
@stop
