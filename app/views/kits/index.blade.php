@extends('layouts.admin')
@section('headerScript')
{{ HTML::style('css/kits.css') }}
<script src='fullcalendar/lib/jquery.min.js'></script>
<script>
	
var ViewEditKit = "{{ route('kits.edit'); }}";
	
	
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
	$('#type').val(0);
	//add "Mine" to branch filter
	$('#branch').prepend('<option value="0">All</option>');
	$('#branch').val(0);

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
			addRow("#kits", null);
		else{
			for (var i = 0; i < kits.length; i++) {
				addRow("#kits", kits[i]);
			}
			$('#kits tr').first().toggleClass('selected');
			$('.editRoute').attr('href', ViewEditKit.replace('%7Bkits%7D', $('.selected').attr('id')));
		}
	}

	function clearTable(tableID) {
		$(tableID).empty();
		$('.editRoute').attr('href', '#');
	}
	
	function addRow(tableID, kit) {
		var row = document.createElement('tr');
		
		if (kit == null) {
			var cell = $(document.createElement('td')).text("No Kits");	
			$(row).append(cell);
			$(tableID).append($(row));
		} else {
			$(row).append($(document.createElement('td')).text(kit.description));
			$(row).append($(document.createElement('td')).text(kit.name));
			$(row).append($(document.createElement('td')).text(kit.barcode));
			$(row).append($(document.createElement('td')).text(branchList[kit.currentBranchID]));
			
			var isDamaged = $.grep(allDamagedKits, function(e){ return e.id == kit.id; });
			if (isDamaged.length > 0) {
				$(row).append($(document.createElement('td')).text("Has Damage"));
			} else {
				$(row).append($(document.createElement('td')).text("None"));
			}
			
			$(row).attr('id',  kit.id);
			$(tableID).append($(row));
			
			$(tableID).on('click', '#' + kit.id, function() {
				$('.selected').each(function() {
					$(this).toggleClass('selected');
				});
				$(this).toggleClass('selected');
				$('.editRoute').attr('href', ViewEditKit.replace('%7Bkits%7D', $(this).attr('id')));
			});
			
		}
	}
	
	
	
	
	$('#branch').change(updateTable);
	$('#type').change(updateTable);
	$('#damage').change(updateTable);

	updateTable();
});
</script>
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
			<tbody></tbody>
		</table>
	</div>
</div>

<div class="navMenu" id="buttons">
<ul>

    @if(Auth::user()->role == 1)
      <li>
       	<a href="#" class="editRoute">View/Edit Kit</a>
      </li>
    @endif
</ul>
</div>


@stop