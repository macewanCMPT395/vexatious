@extends('layouts.admin')
@section('headerScript')
{{ HTML::style('css/kits.css') }}
{{ HTML::style('css/tableList.css') }}
{{ HTML::style('css/tableFilter.css') }}
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
<script>
	
var ViewEditKit = "{{ route('kits.edit'); }}";
function initTable() {
	//add in our table headers into the table layout
	//add headers
	$('#kitListing .table-static-header-row')
		.append($('<td></td>').text('Description'))
		.append($('<td></td>').text('Kit Type'))
		.append($('<td></td>').text('Barcode'))
		.append($('<td></td>').text('Current Branch'))
		.append($('<td></td>').text('Condition'));
}
	
	
$(document).ready(function() {
	initTable();
	
	//Add Rows to table    
	var branchList = {{ json_encode(Branch::lists('name', 'id')) }};
	var allKits = {{ json_encode($kits); }};
	var allDamagedKits = {{ json_encode($kitDamage); }};

	//add "All" to type filter
	$('#type').prepend('<option value="0">All</option>');
	$('#type').val(0);
	//add "Mine" to branch filter
	$('#branch').prepend('<option value="0">All</option>');
	$('#branch').val(0);

	function filterKits() {
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

	function populateTable(kitList){
		var table = $('#kitListing .table-rows-table');
		if(kitList.length == 0) {
			var row = document.createElement('tr');
			$(row).append($('<td></td>').text("No Kits found"));
			table.append($(row));
			$('.editRoute').attr('href', '#');
			return;
		}
		
		
		kitList.forEach(function(kit) {
			var row = document.createElement('tr');
			$(row).attr('id', kit.id);


			//add asset tag
			$(row).append($('<td></td>').text(kit.description));
			//add name
			$(row).append($('<td></td>').text(kit.name));
			$(row).append($('<td></td>').text(kit.barcode));
			$(row).append($('<td></td>').text(branchList[kit.currentBranchID]));
			
			var isDamaged = $.grep(allDamagedKits, function(e){ return e.id == kit.id; });
			if (isDamaged.length > 0) {
				$(row).append($('<td></td>').text("Damaged"));
			} else {
				$(row).append($('<td></td>').text("Good"));
			}

			table.append($(row));
			table.on('click', '#' + kit.id, function() {
				$('.selected').each(function() {
					$(this).toggleClass('selected');
				});
				$(this).toggleClass('selected');
				$('.editRoute').attr('href', ViewEditKit.replace('%7Bkits%7D', $(this).attr('id')));
			});
		});	
		$('#kitListing .table-rows-table tr').first().toggleClass('selected');
		$('.editRoute').attr('href', ViewEditKit.replace('%7Bkits%7D', $('.selected').attr('id')));
	}				  
				  
				  
	function updateTable() {
		var kits = filterKits();
		$('#kitListing .table-rows-table').empty();
		populateTable(kits);
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

<ul class="TableFilter-Bar">
	<li>
	{{ Form::label('type', 'Type') }}
	{{ Form::select('type', HardwareType::lists('name', 'id')) }}
	</li>
	<li class="TableFilter-Content">
	{{ Form::label('branch', 'Branch') }}
	{{ Form::select('branch', Branch::lists('name', 'id')); }}
	</li>
	<li class="TableFilter-Content">
	{{ Form::label('damage', 'Damage') }}
	{{ Form::select('damage', array('a' => 'All', 'd' => 'Damaged', 'n' => 'None')) }}
	</li>
</ul>

<div id="kitListing">
	@include('layouts.tableList')
</div>

<div class="navMenu footer">
<ul>

    @if(Auth::user()->role == 1)
      <li>
       	<a href="#" class="editRoute">View/Edit Kit</a>
      </li>
    @else
	   <li>
       	<a href="#" class="editRoute">View Kit</a>
      </li>
	@endif
</ul>
</div>


@stop