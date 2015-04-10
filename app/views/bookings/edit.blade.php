@extends('layouts.header')
@section('headerScript')
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::style('css/bookingview.css') }}
@stop

@section('content')


<div class="EditBookingDiv">
	{{ Form::open(['method' => 'put',
	               'id' => 'form-edit_booking',
                       'route' => ['bookings.update', $booking->id]
	])}}
		<div class="EventNameDiv">
		<b>{{ Form::label('_eventlbl', 'Edit Event Name: ') }}</b>
		{{ Form::text('eventName', $booking->eventName) }}
		</div>
		<div class="EventNameDiv">
		<div class="NotificationLabelDiv">
		<center>
		<b>{{ Form::label('NotificationLabelInfo', 'Edit who gets notified when this item arrives:') }}</b>
		</center>
		</div>
		<div class="EmployeeSearchDiv">

		<center>
		<select id="EmployeeBox" selected="">
		<option value= -1> Please select a user</option>
		@foreach(User::all(['email', 'firstName', 'lastName', 'id']) as $user)
				<option value={{$user->id}}>{{ $user->email.' | '.$user->firstName.' '.$user->lastName }}</option>
		@endforeach
		</select>
		{{ Form::button('Add', array('id' => 'addemployeebtn')) }}
		</center>
		</div>
		</div>
		<div id="EmployeeNotifyDiv"></div>
	
		<div class="buttons">
		<div class="SubmitCancelDiv">
			{{ Form::submit('Confirm') }}
		</div>
	{{ Form::close() }}
	<div class="DeleteBookingDiv">
	{{ Form::open(['method' => 'DELETE',
	               'route' => ['bookings.destroy', $booking->id],
	               'id' => 'form-delete_booking'
			
	])}}
	{{ Form:: submit('Delete') }}
	</div>
	</div>
</div>

<script type="text/javascript">

var useridstr = "user_";
var hiddenidstr = "hidden_";
	
/*
When the page loads, populate users who 
are already associated with this event
*/	
//setting up a callback for when a user is removed
var _onUserClick = null;
function onUserClick(fn) {
	_onUserClick = function (user) {
		fn(user);	
	}
}
	
function createEmployeeInput(employeeID, num) {			
	var divID = useridstr + employeeID;
	
	var optionBoxSelect = $('#EmployeeBox [value="' + employeeID + '"]');
	
	var parentBox = $(document.createElement("div")).attr("id", divID);
	var hiddenselect = $(document.createElement("input"))
							.attr("type", "hidden")
							.attr("id", hiddenidstr + employeeID)
							.attr("value", employeeID)
							.attr("name", hiddenidstr + num)
							.appendTo(parentBox);
	var emailtext = $(optionBoxSelect).text();


	var userbox = $(document.createElement("input"))
		.attr("type", "text")
		.attr("data-user-id", employeeID)
		.val(emailtext)
		.attr("size", "35")
		.appendTo(parentBox);

	var image = $(document.createElement('img'))
			.attr('src','{{$url = asset('images/delete.png')}}')
			.attr('id','deleteimg')
			.appendTo(parentBox);

	$("#EmployeeNotifyDiv").append(parentBox);	
	$('#'+divID).find('img').on('click', function(){
		var user = {text: emailtext, id: employeeID};
		_onUserClick(user);	
	});
	
	
	$(optionBoxSelect).remove();
	
}
	
	
function populateBookees(associatedList ) {
	var curCount = 1;
	associatedList.forEach(function(user) {
		createEmployeeInput(user.id, curCount);
		curCount++;
	});
	
	return curCount;
}
	
	
	
$(document).ready(function() {
	var associated = {{ json_encode($users); }};
	$("#EmployeeBox").selectedIndex = 0;

	var num = populateBookees(associated);
	console.log("num " + num);
	
	
	onUserClick(function(user) {
		$("<option></option>").attr("value", user.id).text(user.text).appendTo("#EmployeeBox");
		$('#' + useridstr + user.id).remove();
		num--;
	});


	$("#addemployeebtn").on("click", function() {
		var value = $('#EmployeeBox option:selected').val();

		if(value == -1) return;
		else {
			createEmployeeInput($("#EmployeeBox option:selected").val(), num);
			num++;
		}
	});
	
});
</script>
@stop

