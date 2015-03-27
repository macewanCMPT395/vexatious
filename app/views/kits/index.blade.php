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
    {{ Form::label('damage', 'Damage') }}
    {{ Form::select('damage', array('a' => 'All', 'd' => 'Damaged', 'n' => 'None')) }}
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
<div class="navMenu" id="buttons">
<ul>
    <li>
	{{HTML::linkRoute('reportdamage', 'Report Damage') }}
	</li>
    <li>
        {{HTML::linkRoute('bookings.index', 'Book Kit') }}
    </li>
    @if(Auth::user()->role == 1)
      <li>
        {{ HTML::linkRoute('kits.edit','Edit Kit') }}
      </li>
    @endif
</ul>
</div>
<script>
	
$(document).ready(function() {
	//Make Table Rows selectable
	var selected;
	//Add Rows to table    
	var branchList = {{ json_encode(Branch::lists('name', 'id')) }};
	var allKits = {{ json_encode($kits); }};
	var allDamagedKits = {{ json_encode($kitDamage); }};
	console.log(allDamagedKits);
	var kits;

	//add "All" to type filter
	$('#type').prepend('<option value="0">All</option>');
	//add "Mine" to branch filter
	$('#branch').prepend('<option value="0">All</option>');

	function filterBookings() {
		//first, only grab the bookings for the current branch
		var filterKits = allKits.filter(function(a) {

			var branchAdd = ($('#branch').val() == 0 || a.currentBranchID == $('#branch').val());
			var damaged = $('#damage').val();
			//if we are sorting for damage, auto remove kits that have no damage
			var isDamaged = $.grep(allDamagedKits, function(e){ return e.id == a.id; });
			if (damaged == 'n' && isDamaged.length > 0) {
				return false;
			} else if (damaged == 'd' && isDamaged.length <= 0)
				return false;
			
			if ($('#type').val() == 0) {
				return branchAdd;
			} else {
				return branchAdd && a.type == $('#type').val();
			}
		});


		return filterKits;
	}	

	function updateTable() {
		//Filter Kits
		//Filter by type
		kits = filterBookings();
			//allKits.filter(function(a) {
			//return a.type == $('#type').val(); });

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
			
			
			var isDamaged = $.grep(allDamagedKits, function(e){ return e.id == b.id; });
			if (isDamaged.length > 0) row.insertCell(4).innerHTML= "Damaged";
			else row.insertCell(4).innerHTML= "None";
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
	
	$('#branch').change(updateTable);
	$('#type').change(updateTable);
	$('#damage').change(updateTable);

	updateTable();
});
</script>

@stop