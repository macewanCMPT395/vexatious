@extends('layouts.admin')

@section('headerScript')
{{ HTML::style('css/kits.css') }}
<script src='fullcalendar/lib/jquery.min.js'></script>
@stop
@section('browsekitsli') class="active" @stop
@section('content')
<div class="kitFilter">
    {{ Form::open(['method' => 'get', 'route' => 'browsekits']) }}
    <div class="title"></div>
    <ul class="kitFilter">
    <li>
    <div class="filterTitle">Filter By</div>
    </li>
    <li>
    {{ Form::label('type', 'Type') }}
    {{ Form::select('type', array('ipad' => 'iPad', 'zune' => 'Zune')) }}
    </li>
    <li>
    {{ Form::label('branch', 'Branch') }}
    {{ Form::select('type', array('dt' => 'Downtown', 'ut' => 'Uptown')) }}
    </li>
    <li>
    {{ Form::label('damage', 'Damage') }}
    {{ Form::select('damage', array('a' => 'All', 'd' => 'Damaged', 'n' => 'None')) }}
    </li>
    <li>
    {{ Form::submit('Filter') }}
    </li>
    </ul>
    {{ Form::close() }}
</div>
<div id="tableWrapper">
<table class="kitsTable">
<thead>
<tr>
    <th>Description</th>
    <th>Kit Type</th>
    <th>Barcode</th>
    <th>Current Branch ID</th>
    <th>Damage</th>
</tr>
</thead>
</table>
<div id="tableRows">
<table class="kitsTable kitRows">
<tbody>
    @for ($i = 0; $i < 100; $i++) 
        @foreach ($kits as $kit)
        <tr>
            <td>{{$kit->description}}</td>
            <td>{{$kit->type}}</td>
            <td>{{$kit->currentBranchID}}</td>
            <td>{{$kit->barcode}}</td>
            <td>None</td>
        </tr>
        @endforeach
    @endfor
</tbody>
</table>
</div>
</div>

<script>
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