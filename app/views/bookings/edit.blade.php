@extends('layouts.header')
@section('headerScript')
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::style('css/bookingview.css') }}
@stop

<?php
	$num = 1;
?>

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
		<div id="EmployeeNotifyDiv">
		@foreach($users as $user)
			<div id="user_{{$user->id}}"> {{ Form::text('user_'.$num, $user->email.' | '.$user->firstName.' '.$user->lastName, ['data-user-id' => $user->id, 'size' => '35', 'class' => 'userbox']) }} 
			<img id="deleteimg" src={{$url = asset("images/delete.png")}}>
			</div>
		@endforeach
		</div>
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
$(document).ready(function() {

	$("#EmployeeBox").selectedIndex = 0;

	var useridstr = "user_";
	var hiddenidstr = "hidden_"
	var num = {{ $num }};

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
				num --;

			});

		}

	});

	$(".userbox").each(function(){

		var id = $(this).attr('data-user-id');
		$('#EmployeeBox option[value="'+id+'"]').remove();

	});

	$("#addemployeebtn").on("click", function()
	{

		if($("#EmployeeBox").val() == -1)
		{

			return;

		}
		else
		{
			var parentBox = $(document.createElement("div")).attr("id", useridstr + $("#EmployeeBox option:selected").val());
			var hiddenselect = document.createElement("input");
			var emailtext = $("#EmployeeBox option:selected").text();
			
			hiddenselect.type = "hidden";

			var userbox = $(document.createElement("input"))
				.attr("type", "text")
				.attr("data-user-id", $("#EmployeeBox option:selected").val())
				.val(emailtext)
				.attr("size", "35")
				.appendTo(parentBox);

			var image = $(document.createElement('img'))
					.attr('src','{{$url = asset('images/delete.png')}}')
					.attr('id','deleteimg')
					.appendTo(parentBox);

			hiddenselect.id = hiddenidstr + $("#EmployeeBox option:selected").val();
			hiddenselect.value = $("#EmployeeBox").val();
			hiddenselect.name = hiddenidstr + num;
			parentBox.append(hiddenselect);
			num ++;
			$("#EmployeeBox option:selected").remove();

			$("#EmployeeNotifyDiv").append(parentBox);
			

		}

	});

});
</script>
@stop

