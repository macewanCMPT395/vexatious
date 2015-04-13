@extends('layouts.admin')

@section('headerScript')
{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::script('js/Hardware.js') }}
{{ HTML::script('js/post.js') }}
{{ HTML::style('css/showHardware.css') }}
{{ HTML::style('css/loadingScreen.css') }}
<script>
	
$(document).ready(function() {
	var kitID = {{ $hardware->id }}


	var HWForm = HardwareForm.init({
		hwInfoRoute: "{{ route('hardware.show'); }}",
		kitInfoRoute: "{{ route('kits.edit'); }}"
	});
	
	HWForm.getStart(function(){
		$('.loadingImg').show();
		console.log("start");
	});
	HWForm.getDone(function(){
		console.log("Done");
		$('.loadingImg').hide();
	});

	HWForm.fill(kitID);
	HWForm.post();
});
</script>

@stop

@section('content')
	@include('layouts.hardware')
	@include('layouts.loadingScreen')
@stop