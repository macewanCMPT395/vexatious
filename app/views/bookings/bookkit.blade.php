@extends('layouts.header')
@section('headerScript')
{{ HTML::style('css/calendar.css') }}
{{ HTML::style('css/bookkit.css') }}
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::script('lightbox.js') }}
{{ HTML::style('css/lightbox.css') }}
{{ HTML::script('polyfiller.js') }}
@stop
@section('bookkitli') class="active" @stop
@section('content')

<script> 
//enable date picker for firefox
webshims.setOptions('forms-ext', {types: 'date'});
webshims.polyfill('forms forms-ext');
	
webshims.formcfg = {
        en: {
            dFormat: '-',
            dateSigns: '-',
            patterns: {
                d: "dd-mm-yy"
            }
        }
};
webshims.activeLang('en');
	

$(document).ready(function() {
	var hasStart = 0, hasEnd = 0, hasKit = 0;
	
	var myLightBox = LightBox.init();
	var startSelector = "input[name='start']";
	var endSelector = "input[name='end']";
	
	$('#kitCodeLabel').attr('readonly', true);
	$('#kitCodeLabel').css('background-color' , '#DEDEDE');
	
	function updateSelectButton() {
		var startDate = $(startSelector).val();
		var endDate = $(endSelector).val();
		
		$('#selectKitBtn').attr('disabled', function() {
			return !startDate || !endDate;
		});	
		
		$("input[type='submit']").attr('disabled', function() {
			return !startDate || !endDate || !$('#kitCodeLabel').attr('data-selected');
		});
	}
	
	function updateSelectedKit() {
		$('#kitCodeLabel').val('No Kit Selected');	
		$('#kitCodeLabel').attr('data-selected', null);
	}
	
	$(startSelector).change(function() {
		updateSelectButton();
		updateSelectedKit();
		
	});
	
	$(endSelector).change(function() {
		updateSelectButton();
		updateSelectedKit();
	});
	
	
	$('#selectKitBtn').click(function() {
		var kitType = $('#type').val();
		var kitName = $('#type option:selected').html();
		
		var startDate = $(startSelector).val();
		var endDate = $(endSelector).val();
		
		var url = "/checkForKit/" + kitType + "/" + startDate + "/" + endDate;
		$.get(url)
			.done(function(data) {
				//create container to hold our list
				var htmlDisplay = document.createElement('div')
				$(htmlDisplay).addClass('kitlist');
				var title2 = '<h2>Between ' + startDate + ' and ' + endDate;
			
				if(data.status == 1) {
					var title1 = '<h1>No ' + kitName + ' kits available';
					$(htmlDisplay).append(title1).append(title2);
					myLightBox.show($(htmlDisplay).html());
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
						$('#kitCodeLabel').val($(this).attr('id'));
						$('#kitCodeLabel').attr('data-selected', 'true');
						myLightBox.close();
						updateSelectButton();
					});
					
					//add generated kit item to the kit list
					$(kitList).append($(listItem));
				});
				//add kit list to our container
				$(htmlDisplay).append($(kitList));
				//and show the container in the lightbox
				myLightBox.show($(htmlDisplay).html());
			})
			.fail(function(data) {
				console.log(data);
				alert(data);
			});
	});
	
	
	//set initial state for our buttons
	updateSelectButton();
	updateSelectedKit();
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
			{{ Form::text('kitCode', 'No Kit Selected', ['id'=>'kitCodeLabel']); }}
		</div>

       <div>
            {{ Form::label('eventName', 'Event Name: ', ['id' => 'eventLabel']) }}
            {{ Form::text('eventName') }}
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