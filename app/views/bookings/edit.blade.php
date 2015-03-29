@section('content')

{{ HTML::script('fullcalendar/lib/jquery.min.js') }}

	<div class="EditBookingDiv">
	{{ Form::open(['method' => 'PUT',
	               'id' => 'form-edit_booking',
                       'route' => ['booking.update', $bookings->id]
	])}}
		<div class="EventNameDiv">
		{{ Form::label('_eventlbl', 'Edit Event Name: ') }}
		{{ Form::text('eventName') }}
		</div>

		<div class="NotificationLabelDiv">
		<center>
		<b>{{ Form::label('NotificationLabelInfo', 'Edit who gets notified when this item arrives:') }}</b>
		</center>
		</div>
		<div class="EmployeeSearchDiv">

		<center>
		<select id="EmployeeBox" selected="">
		
		<option SELECTED value=-1>
		@foreach(User::all(['email', 'firstName', 'lastName', 'id']) as $user)
				<option value={{$user->id}}>{{ $user->email.' | '.$user->firstName.' '.$user->lastName }}</option>
		@endforeach
		</select>
		{{ Form::button('Add', array('id' => 'addemployeebtn')) }}
		</center>
		</div>
		<div id="EmployeeNotifyDiv">
		</div>
		<div class="SubmitCancelDiv">
			<center>
			{{ Form::submit('Confirm') }}
			{{ Form::button('Go Back', array('id' => 'cancelbtn')) }}
			</center>
		</div>
		</div>
	{{ Form::close() }}
	</div>
	<div class="DeleteBookingDiv">
	{{ Form::open(['method' => 'DELETE',
	               'route' => ['booking.destroy', $booking->id],
	               'id' => 'form-delete_booking'
			
	])}}
	{{ Form:: submit('Delete') }}
	</div>

<script type="text/javascript">
$(document).ready(function() {

	$("#EmployeeBox").selectedIndex = 0;

	var useridstr = "user_";
	var hiddenidstr = "hidden_";

	$("#EmployeeBox option").each(function() {

		if($(this).val() == -1)
		{

			return;

		}
		else
		{

			var val = $(this).val();

			var thisID = useridstr + val;
			$("#EmployeeNotifyDiv").on("click", "#" + thisID, function()
			{

				$("<option></option>").attr("value", $(this).attr("data-user-id")).text($(this).val()).appendTo("#EmployeeBox");
				$(this).remove();
				console.log(hiddenidstr + val);
				$("#" + hiddenidstr + val).remove();

			});

		}

	});

	$("#addemployeebtn").on("click", function()
	{

		if($("#EmployeeBox").val() == -1)
		{

			return;

		}
		else
		{

			var hiddenselect = document.createElement("input");
			var emailtext = $("#EmployeeBox option:selected").text();

			hiddenselect.type = "hidden";

			var userbox = $(document.createElement("input"))
				.attr("type", "text")
				.attr("data-user-id", $("#EmployeeBox option:selected").val())
				.val(emailtext)
				.attr("id", useridstr + $("#EmployeeBox option:selected").val())
				.attr("size", "35");

			hiddenselect.id = hiddenidstr + $("#EmployeeBox option:selected").val();
			hiddenselect.value = $("#EmployeeBox").val();

			$("#EmployeeBox option:selected").remove();

			$("#EmployeeNotifyDiv").append(userbox);
			$("#EmployeeNotifyDiv").append(hiddenselect);

		}

	});

});
</script>

