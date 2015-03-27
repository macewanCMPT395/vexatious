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
                d: "yy-mm-dd"
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
		populateTable(kitType,startDate,endDate);
	}); 
	
	
	//set initial state for our buttons
	updateSelectButton();
	updateSelectedKit();

function populateTable(kitType,startDate,endDate) {
	 $('.availableKits.tbody').empty();
	 var url = "/checkForKit/" + kitType + "/" + startDate + "/" + endDate;
	 console.log(url);
	 $.get(url)
		.done(function(data) {
				if(data.status == 1) {
					return;
				}

	 data.available.forEach(function(kit) {
	 	var cell1 = "<td>" + kit.barcode + "</td>";
		var cell2 = "<td>" + kit.type + "</td>";
		var cell3 = "<td>" + kit.description + "</td>";
		var curRow = document.createElement('tr');
		
		$(curRow).append(cell1).append(cell2).append(cell3);
		$('.availableKits').append($(curRow));
		}); 		 
		});    
}
});
</script> 
<table class="booking">
    <tr>
    <td id="selectors">
    <div class="bookingBox">
       {{ Form::open([ 'route' => 'bookings.store',
                        'id' => 'form-booking']
        )}}
	<ul class="bookkit">
	    <li>
		{{ Form::label('eventName', 'Event Name: ', ['id' => 'eventLabel']) }}
            	{{ Form::text('eventName') }}
	     </li>
	     <li>
			{{ Form::label('type', 'Type:') }}
			{{ Form::select('type', HardwareType::lists('name', 'id')) }}
	     </li>
	     <li>
		   {{ Form::label('destination', "Deliver To: ", ['id' => "destLabel"]) }}
            	   {{ Form::select('destination', Branch::lists('name', 'id')) }}
  	      </li>
	      <li>
		{{ Form::label('start', 'Start Date: ', ['id' => 'startDateLabel']) }}
            	{{ Form::input('date', 'start') }}
	      </li>
	      <li>
               {{ Form::label('end', 'End Date: ', ['id' => 'endDateLabel']) }}
               {{ Form::input('date', 'end') }}
       	      </li>
	       <li>
			{{ Form::button('Check Kit Availability', ['id'=>'selectKitBtn']); }}
			{{ Form::hidden('kitCode', 'No Kit Selected', ['id'=>'kitCodeLabel']); }}
	 	</li>
		<li>
		<!-- add the notification table and adder function here -->
		</li>
		<li>
		<div class="bookingButtons"> {{ Form::submit('Create Booking') }}</div>
		<div id="bookingErrorMsg"></div>
		</li>
       		</ul>

       {{ Form::close() }}
    </div>
    </td>
    <td>
	<div id="headerLabel">Please select which kit you would like to book</div>
	<table class="availableKits">	
		<thead>
		<th>Bar Code</th>
		<th>Status</th>
		<th>Description</th>
		</thead>
		<tbody>
		</tbody>
	</table> 
    </td>
    </tr>
</table>
		 
@stop