@extends('layouts.admin')
@section('headerScript')
{{ HTML::style('css/kits.css') }}
<script src='fullcalendar/lib/jquery.min.js'></script>
@stop
@section('browsekitsli') class="active" @stop
@section('content')
<div>
    {{ Form::open(['method' => 'get', 'route' => 'kits.index']) }}
    <div class="title"></div>
    <ul class="kitFilters">
    <li>
    {{ Form::label('type', 'Type') }}
    {{ Form::select('type', HardwareType::lists('name', 'id')) }}
    </li>
    <li>
    {{ Form::label('branch', 'Branch') }}
    {{ Form::select('branch', Branch::lists('name', 'id')); }}
    </li>
    <li>
    {{ Form::label('barcode', 'Barcode') }}
    {{ Form::text('barcode') }}
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
    <th>Current Branch</th>
    <th>Damage</th>
</tr>
</thead>
</table>
<div id="tableRows">
<table id="kits" class="kitsTable kitRows">
<tbody>
	@for($i = 0; $i < 100; $i++)
       	@foreach ($kits as $kit)
        <tr>
            <td>{{$kit->description}}</td>
            <td>{{$kit->name}}</td>
            <td>{{$kit->barcode}}</td>
            <td>{{$kit->identifier}}</td>
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
var selected;
//Add Rows to table    
var branchList = {{ json_encode(Branch::lists('name', 'id')) }};
var allKits = {{ json_encode($kits); }};
var kits;

$('#branch').change(updateTable);
$('#type').change(updateTable);

updateTable();

function updateTable() {
    //Filter Kits
    //Filter by type
    kits = allKits.filter(function(a) {
        return a.type == $('#type').val(); });
    
    clearTable("#kits");
    populateTable();
}
    
function populateTable() {
    
    if (kits.length == 0)
        addRow("kits", null);
    else{
        for (var i = 0; i < kits.length; i++) {
            addRow("kits", kits[i]);
        }
    }
}
    
function clearTable(tableID) {
    $(tableID).empty();
}

function addRow(tableID, b) {
    var table = document.getElementById(tableID);
    var rowCount = table.rows.length;
    var row = table.insertRow(rowCount);
    if (b == null)
        row.insertCell(0).innerHTML= "No Kits";
    else {
        row.insertCell(0).innerHTML= b.description;
        row.insertCell(1).innerHTML= b.name;
        row.insertCell(2).innerHTML= b.barcode;
        row.insertCell(3).innerHTML= branchList[b.currentBranchID];
        row.insertCell(4).innerHTML= "None";
    }
    
    row.className += " row";
    
    //Make row selectable
    row.onclick = function() {
            if (selected != null)
                selected.classList.toggle('selected');
            selected = this;
            selected.classList.toggle('selected');
            if (b != null) {
                document.getElementsByName("id")[0].value = b.bookingID;
                document.getElementsByName("shipped")[0].value = 1;
                document.getElementsByName("received")[0].value = 0;
            }
        }
}
</script>

@stop