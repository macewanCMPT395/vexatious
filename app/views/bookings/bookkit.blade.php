@extends('layouts.header')
@section('headerScript')
{{ HTML::style('css/calendar.css') }}
{{ HTML::style('css/bookkit.css') }}
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::script('lightbox.js') }}
{{ HTML::style('css/lightbox.css') }}

@stop
@section('bookkitli') class="active" @stop
@section('content')

<script> 


$(document).ready(function() {
	var myLightBox = LightBox.init();
	
	$('#selectKitBtn').click(function() {
		var kitType = $('#type').val();
		var kitName = $('#type option:selected').html();
		
		var startDate = $("input[name='start']").val();
		var endDate = $("input[name='end']").val();
		
		var url = "/checkForKit/" + kitType + "/" + startDate + "/" + endDate;
		console.log(url);
		$.get(url)
			.done(function(data) {
				//create container to hold our list
				var htmlDisplay = document.createElement('div')
				$(htmlDisplay).addClass('kitlist');
				var title2 = '<h2>Between ' + startDate + ' and ' + endDate;
			
				if(data.status == 1) {
					var title1 = '<h1>No ' + kitName + ' kits available';
					$(htmlDisplay).append(title1).append(title2);
					return;
				}
			

			
				//add some title to the container
				var title1 = '<h1>Available ' + kitName + ' Kits</h1>';
				$(htmlDisplay).append(title1).append(title2);
			
				//create and generate list			
				var kitList = document.createElement('ul');

				data.available.forEach(function(kit) {
					//create list item
					var kitStr = kit.barcode + ': ' + kit.description;
					var listItem = document.createElement('li');
					$(listItem).addClass('kitListItem').attr('id', kit.barcode).html(kitStr);
						
					//do a check for if a list item is clicked, then close lightbox
					//and add kits barcode to selected kit field label
					$('#lightBox').on('click','#' + kit.barcode, function() {
							console.log("Clicked!");
							$('#kitCodeLabel').text($(this).attr('id'));
							myLightBox.close();
					});
					
					//add generated kit item to the kit list
					$(kitList).append($(listItem));
				});
				//add kit list to our container
				$(htmlDisplay).append($(kitList));
				//and show the container in the lightbox
				myLightBox.show($(htmlDisplay).html());
			});
	});
	
	
	
	
	
	
	
	
});

</script>

    <div class="bookingBox">
       {{ Form::open([ 'route' => 'bookings.store',
                        'id' => 'form-booking']
        )}}

		<div>
			{{ Form::label('type', 'Type') }}
			{{ Form::select('type', HardwareType::lists('name', 'id')) }}
		</div>
       <div>
            {{ Form::label('start', 'Start Date: ', ['id' => 'startDateLabel']) }}
            {{ Form::input('date', 'start') }}
       </div>

        <div>
            {{ Form::label('end', 'End Date: ', ['id' => 'endDateLabel']) }}
            {{ Form::input('date', 'end') }}
       </div>
		
		<div>
			{{ Form::button('Select Kit', ['id'=>'selectKitBtn']); }}
			{{ Form::label('kitCode', 'No Kit Selected', ['id'=>'kitCodeLabel']); }}
		</div>

       <div>
            {{ Form::label('eventName', 'Event Name: ', ['id' => 'eventLabel']) }}
            {{ Form::password('eventName') }}
       </div>



       <div>
		   {{ Form::label('destination', "Deliver To: ", ['id' => "destLabel"]) }}
            {{ Form::select('destination', Branch::lists('name', 'id')) }}

       </div>


        <div id="bookingErrorMsg"></div>

       <div class="bookingButtons"> {{ Form::submit('Create Booking') }}</div>

       {{ Form::close() }}
    </div>
@stop