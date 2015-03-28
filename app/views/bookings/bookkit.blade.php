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
//These must be set before document ready	
//enable date picker for firefox
webshims.formcfg = {
		en: {
			dFormat: '-',
			dateSigns: '-',
			patterns: {
				d: "yy-mm-dd"
			}
		}
};

webshim.setOptions('forms', {
	addValidators: true
});

webshim.setOptions("forms-ext", {
	replaceUI: 'auto',
	types: 'date',
	"date": {
		"startView": 2,
		"size":2,
		"popover": {
			"position": {
				"at": "right bottom"
			}
		}
	}
});
webshims.polyfill('forms forms-ext');
webshims.activeLang('en');
	
$(document).ready(function() {
	//kill chromes date picker
   $('input[type=date]').on('click', function(event) {
        event.preventDefault();
    });
	
	var holidays = {{ json_encode(Holiday::lists('date')); }};
	
	
	$('input.min-today').prop('min', function(){
		var curDate = new Date();
		//since bookings need to be made 2 days in advanced...
		var day = curDate.getUTCDate();
		//curDate.setDate(day);
	
		//if current day is friday, can't make a booking
		//for monday
		if (curDate.getUTCDay() == 5) {
			day += 4;	
			curDate.setDate(day);
		} else {
			//otherwise
			day += 2;//can only make a booking
			curDate.setDate(day);
		}
		//if this falls on a saturday or sunday, black those out too
		while(curDate.getUTCDay() == 6 || curDate.getUTCDay() == 0 || curDate.getUTCDay() == 1) {
			curDate.setDate(++day);	
			day = curDate.getUTCDate();
		}
		
        return curDate.toJSON().split('T')[0];
    }).on('validatevalue', function (e, data) {
		var date = data.valueAsDate.toISOString().split('T')[0];

		var isHoliday = holidays.filter(function(d) {
			return d == date;
		});
		var day = data.valueAsDate.getUTCDay();
	
		return (isHoliday.length > 0 || day == 6 || day == 0)
		return false;
	});

	
	
	
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
            	{{ Form::input('date', 'start', '',
			  		['class'=>'disable-weekends min-today', 'placeholder'=>'yyyy-mm-dd', 'required'=> ""])
			  	}}
	      </li>
	      <li>
               {{ Form::label('end', 'End Date: ', ['id' => 'endDateLabel']) }}
               {{ Form::input('date', 'end', '', 
			  		['class'=>'min-today', 'placeholder'=>'yyyy-mm-dd', 'required' => ""]) 
			  	}}
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
		<div id="bookingErrorMsg">
			{{ 
				$errors->first('holidayError');
			}}
		</div>
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