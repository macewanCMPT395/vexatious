@extends('layouts.admin')
@section('headerScript')
{{ HTML::style('css/tableList.css') }}
{{ HTML::style('css/shipping.css') }}
{{ HTML::style('css/tableFilter.css') }}
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::script('fullcalendar/lib/moment.min.js') }}

@stop
@section('receivingli') class="active" @stop
@section('content')
<ul class="TableFilter-Bar">
	{{ Form::open(['method' => 'put', 'route' => 'bookings.update', 'id' => 'form-receiving']) }}
	<li>
		{{ Form::label('branch', 'Receiving at') }}
		{{ Form::select('branch', Branch::lists('name', 'id')); }}
	</li>
	<li>
		{{ Form::hidden('form', 'received') }}
		{{ Form::hidden('received', '1') }}
	</li>
	{{Form::close() }}
</ul>

 <div id="todayTable">
	<div class="tableTitle">Today </div>
	<div id="todayDate"> [Today's Date] </div>
	<div class="tableWrapper">
		 @include('layouts.tableList')
	</div>
 </div>

 <div id="tomorrowTable">
	<div class="tableTitle">Tomorrow </div>
	<div id="tomorrowDate"> [Tomorrow's Date] </div>
	<div class="tableWrapper">
		 @include('layouts.tableList')
	</div>
 </div>

<div class="navMenu footer">
	<ul>
	  <li>
		<a href="#" id="createBooking">Received Kit</a>
	  </li>
	</ul> 
</div>

<script>
	
$(document).ready(function() {
	var submitRoute = $('#form-receiving').attr("action");
	//Set Table Dates
	var todayTitle = document.querySelector("#todayDate");
	var tomorrowTitle = document.querySelector("#tomorrowDate");

	var today = new Date(moment());
	var tomorrow = new Date(moment(today).add(1,'days'));

	$(".navMenu.footer").css('bottom','-10%');

	todayTitle.innerHTML = moment().format("dddd, MMMM Do YYYY");
	tomorrowTitle.innerHTML = moment(today).add(1,'days').format("dddd, MMMM Do YYYY");

	//Add Rows to table
	var typeList = {{ json_encode(HardwareType::lists('name', 'id')) }};  
	var branchList = {{ json_encode(Branch::lists('name', 'id')) }};
	var allBookings = {{ json_encode($bookings['bookings']); }};
	var todaysBookings;
	var tomorrowsBookings;

	//Set the headers for both tables
	$('.table-static-header-row')
		   .append($('<td></td>').text('BarCode'))
		   .append($('<td></td>').text('Type'))
		   .append($('<td></td>').text('Coming From'));

	updateTables(); 
	$('#branch').change(updateTables);

	function updateTables() {
		getShipping();
		populateTables();
	}

	function getShipping() {
			 var currentBranch = $('#branch').val();
			var day = 24 * 60 * 60 * 1000;
			 todaysBookings = allBookings.filter(function(a) {

					var today = new Date();
					var shipStart = new Date((a.shipping * 1000) - day);
					return (a.destination == currentBranch &&
							shipStart.getFullYear() == today.getFullYear() &&
							shipStart.getMonth() == today.getMonth() &&
							shipStart.getUTCDate() == today.getUTCDate() &&
							parseInt(a.received) == 0); 
			 });

			tomorrowsBookings = allBookings.filter(function(a) {
					var tomorrow = new Date(new Date().getTime() + 24 * 60 * 60 * 1000);
					var shipStart = new Date((a.shipping * 1000) - day);
					return (a.destination == currentBranch &&
							shipStart.getFullYear() == tomorrow.getFullYear() &&
							shipStart.getMonth() == tomorrow.getMonth() &&
							shipStart.getUTCDate() == tomorrow.getUTCDate() &&
							parseInt(a.received) == 0); 
			});
	}

	function populateTables() {
		var todaysTable = $('#todayTable .table-rows-table');
		var tomorrowsTable = $('#tomorrowTable .table-rows-table');
		todaysTable.empty();
		tomorrowsTable.empty();
		if (todaysBookings.length == 0) {
			var row = document.createElement('tr');
			$(row).append($('<td></td>').text("No Kits Coming In"));
			todaysTable.append($(row));
		} else {
			todaysBookings.forEach(function(booking) {
				var row = document.createElement('tr');
				$(row).append($('<td></td>').text(booking.barcode))
						.append($('<td></td>').text(booking.hname))
						.append($('<td></td>').text(branchList[booking.currentBranchID]));

				var bookingID = booking.bookingID;
				$(row).attr('id',booking.bookingID);
				todaysTable.append($(row));

				todaysTable.on('click', '#'+booking.bookingID, function() {
					$('.selected').each(function() {
						$(this).removeClass('selected');
					});
					$(this).addClass('selected');
					$(".navMenu.footer").animate({bottom:"2%"}, 400, function(){});
					var newRoute = submitRoute.replace("%7Bbookings%7D", bookingID);
					$("#form-receiving").attr("action", newRoute);
				});

			});
		}

		if (tomorrowsBookings.length == 0) {
			var row = document.createElement('tr');
			$(row).append($('<td></td>').text("No Kits To Coming In"));
			tomorrowsTable.append($(row));
		} else {
			tomorrowsBookings.forEach(function(booking) {
 				var row = document.createElement('tr');
 				$(row).append($('<td></td>').text(booking.barcode))
						.append($('<td></td>').text(booking.hname))
						.append($('<td></td>').text(branchList[booking.currentBranchID]));
			 	$(row).attr('id',booking.bookingID);
			 	tomorrowsTable.append($(row));
			 });
		}

		//override our form button with the one in the footer nav
		$('#createBooking').click(function(e) {
			e.preventDefault();
			$('#form-receiving').submit();
		});
	}
	
});
</script>
@stop
