@extends('layouts.admin')

@section('headerScript')
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::script('js/Hardware.js') }}
{{ HTML::script('js/post.js') }}
{{ HTML::style('css/hardware.css') }}
{{ HTML::style('css/tableList.css') }}
<script>
function initTable() {
	//add in our table headers into the table layout
	//add headers
	var header1 = $('<td></td>').text('Asset Tag');
	var header2 = $('<td></td>').text('Name');
	var header3 = $('<td></td>').text('Condition');
	
	
	
	$('#hardwareListing .table-static-header-row').append(header1)
		.append(header2).append(header3);		
}
	
$(document).ready(function() {
	initTable();
	
	//add "All" to type filter
	$('#type').prepend('<option value="0">All</option>');
	$('#type').val(0);
	//add "Mine" to branch filter
	$('#inKit').prepend('<option value="0">All</option>');
	$('#inKit').val(0);
	
	var allDevices = {{json_encode($devices);}};
	
				  
				  
	function filterDevices() {
		//first, only grab the bookings for the current branch
		var filterKits = allDevices.filter(function(a) {
			var branchAdd = ($('#inKit').val() == 0 || ($('#inKit').val() <2 && a.kitID != null));
			var damaged = $('#damage').val();
			//if we are sorting for damage, auto remove kits that have no damage
			//var isDamaged = $.grep(allDamagedKits, function(e){ return e.id == a.id; });
			
			if (damaged == 'n' && a.damaged) {
				return false;
			} else if (damaged == 'd' && !a.damaged)
				return false;

			if ($('#type').val() == 0) {
				return branchAdd;
			} else {
				return branchAdd && a.type == $('#type').val();
			}
		});


		return filterKits;
	}	

	function populateTable(devList){
		var table = $('#hardwareListing .table-rows-table');
		if(devList.length == 0) {
			var row = document.createElement('tr');
			$(row).append($('<td></td>').text("No Devices found"));
			table.append($(row));
			return;
		}
		
		
		devList.forEach(function(device) {
			var row = document.createElement('tr');
			$(row).attr('id', device.id);


			//add asset tag
			$(row).append($('<td></td>').text(device.assetTag));
			//add name
			$(row).append($('<td></td>').text(device.name));

			//add damaged status
			if(device.damaged)
				$(row).append($('<td></td>').text("Damaged"));
			else
				$(row).append($('<td></td>').text("Good"));
		

			table.append($(row));
		});	

	}				  
				  
				  
	function updateTable() {
		var devices = filterDevices();
		$('#hardwareListing .table-rows-table').empty();
		populateTable(devices);
	}


	$('#inKit').change(updateTable);
	$('#type').change(updateTable);
	$('#damage').change(updateTable);

	updateTable();
	
});
</script>

@stop
@section('browsehardwareli') class="active" @stop
@section('content')
<div>
    <ul class="deviceFilters">
    <li>
    {{ Form::label('type', 'Type') }}
    {{ Form::select('type', HardwareType::lists('name', 'id')) }}
    </li>
    <li>
    {{ Form::label('damage', 'Damage') }}
    {{ Form::select('damage', array('a' => 'All', 'd' => 'Damaged', 'n' => 'None')) }}
    </li>
    <li>
    {{ Form::label('inKit', 'In Kit') }}
    {{ Form::select('inKit', ['1'=>'Yes', '2'=>'No'], 1); }}
    </li>
    </ul>
</div>
<div id="hardwareListing">
	@include('layouts.tableList')
</div>
@stop