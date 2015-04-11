@extends('layouts.header')
@section('headerScript')

{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
{{ HTML::script('js/Hardware.js') }}
{{ HTML::script('js/post.js') }}

{{ HTML::style('css/tableList.css') }}
{{ HTML::style('css/hardware.css') }}
{{ HTML::style('css/editkit.css') }}
{{ HTML::style('css/loadingScreen.css') }}


<script>
var KIT_ID = {{$kits->id}};
var kitDevices = {{json_encode($devices);}}
	
var AddAssetFormTemplate = '{{ Form::open(["method" => "post", "route" => "addtokit"]) }}' +
						 	'{{ Form::submit('Add to kit', ['id'=>'addToKitSubmit']) }}' + '{{Form::close()}}';
	
	
function populateInKitAssetsTable(kitAssets) {
	var table = $('.assetTable .table-rows-table');
	
	table.empty();
	//populate the device table for the current kit
	if(kitAssets.length > 0) {
		kitAssets.forEach(function(asset) {
			var row = $(document.createElement("tr"))
						.addClass("deviceRow")
						.attr("id", asset.id);
						//.css("background-color", "f9f9f9");
			
			row.append($(document.createElement("td")).text(asset.assetTag));
			row.append($(document.createElement("td")).text(asset.name));
			row.append($(document.createElement("td")).addClass("deviceStatus").text(function() {
				if(asset.damaged != null) return "Damaged";
				return "Good";
			}));
			
			table.append(row);
		});
	} else {
		var row = $(document.createElement("tr")).addClass("deviceRow");		
		row.append($(document.createElement("td")).text("No assets associated with kit"));
		table.append(row);
	}
}
	
function populateAddAssetTable(freeAssets) {
	var table = $('#addAssetList .table-rows-table');
	table.empty();
	if(freeAssets.length > 0) {
		freeAssets.forEach(function(asset) {
			var row = $(document.createElement("tr"));	

			row.append($(document.createElement("td")).text(asset.assetTag));
			row.append($(document.createElement("td")).text(asset.name));
			row.append($(document.createElement("td")).text(asset.description));
			row.append($(document.createElement("td")).addClass("deviceStatus").text(function() {
				if(asset.damaged != null) return "Damaged";
				return "Good";
			}));

			var newForm = AddAssetFormTemplate.replace("%7BkitID%7D", KIT_ID).replace("%7BhwID%7D", asset.id);
			row.append($(document.createElement("td")).html(newForm));
			
			table.append(row);		
		});
	} else {
		var row = $(document.createElement("tr"));		
		row.append($(document.createElement("td")).text("All assets are associated with kits."));		
		table.append(row);
	}
}
	
	
$(document).ready(function() {
	console.log(AddAssetFormTemplate);
	//since we are already in the kit edit page,
	//we don't need our device info to include a reference url to
	//this page
	$('#hw-kitinfo').hide();
	$('#deleteForm').hide();
	

	//set up the tables
  	$('.assetTable .table-static-header-row')
		.append($('<th>').text('Asset Tag'))
		.append($('<th>').text('Name'))
		.append($('<th>').text('Condition'));		
	
  	$('#addAssetList .table-static-header-row')
		.append($('<th>').text('Asset Tag'))
		.append($('<th>').text('Type'))
		.append($('<th>').text('Description'))
		.append($('<th>').text('Condition'))
		.append($('<th>'));
				  
				  
	populateInKitAssetsTable(kitDevices);
	
	//initialize the inline hardware form
	var HWForm = HardwareForm.init({
		devices: kitDevices,
		hwInfoRoute: "{{ route('hardware.show'); }}",
		kitInfoRoute: "{{ route('kits.edit'); }}",
		hwListRoute: "{{ route('hardware.index'); }}"
	});
	
	//set up the loading screen for various actions
	//regarding the hardware form 
	HWForm.postStart(function() {
		$('.loadingImg').show();
	});
	
	HWForm.getStart(function(){
		$('.loadingImg').show();
	});
	HWForm.getDone(function(){
		$('.loadingImg').hide();
	});
	//set up the post override for the hardware related forms
	HWForm.post();
	
	//set up callback for when an asset is selected on the kit info portion of the page
	$('.assetTable').on('click', '.deviceRow', function() {
		$('.selected').each(function(){ $(this).toggleClass('selected') });
		$(this).toggleClass('selected');
		HWForm.fill($(this).attr('id'));
	});
	if (kitDevices.length > 0) {
		HWForm.fill(kitDevices[0].id);
		$('#'+kitDevices[0].id + '.deviceRow').toggleClass('selected');
	} else {
		HWForm.fill(0);
		$('#0.deviceRow').toggleClass('selected');	
	}
	
	//callback for when the device page is filled
	HWForm.onDeviceFill(function(deviceID) {
		//so we fetched information for a specific asset, now we
		//can update the table listing
		if($('#hw-damage-list > li').length > 0) {
			console.log("updating bad");
			$('#' + deviceID).find('.deviceStatus').text("Damaged");
		} else {
			console.log("updating good");
			$('#' + deviceID).find('.deviceStatus').text("Good");
		}
	});
	
	HWForm.list(function(devices){
			console.log("error getting hardware info");
		}, 
		function(devices) {
			console.log(devices);
			var freeDevices = devices.filter(function(asset) {
				return asset.kitID == null;
			});
			populateAddAssetTable(freeDevices); 
		}
	);

});
</script>



@stop
@section('browsekitsli') class="" @stop
@section('content')
<div class="sideBySide">
<div id="kitInfo">
     {{ Form::open(['method' => 'post', 'route' => 'kits.edit']) }}
	<ul>
	<li>
		{{ Form::label('kitNumber', 'Bar Code:') }}
    		{{ Form::text('KitNumber', $kits->barcode) }}
	</li>
	<li>
		{{ Form::label('currentBranch', 'Current Branch:') }}
		{{ Form::select('CurrentBranch',Branch::lists("name","id"), $kits->currentBranchID, ['id'=>'CurrentBranch'] ) }}
	</li>
	<li>
		{{ Form::label('description', 'Description:') }}
		{{ Form::Input('string', 'description', $kits->description) }}
	</li>
	<li>
	{{ Form::label('assetTable','Items within this kit') }}
	<div class="assetTable">
		@include('layouts.tableList')
	</div>
	</li>
	<li>
	{{ Form::Submit('Apply Changes') }}
	</li>
	</ul>		       
{{ Form::close() }}
</div>
@if(count($devices) > 0)
	<div id="hardware">
		@include('layouts.hardware')
	</div>
	@include('layouts.loadingScreen')

@endif
</div>

<div id="addAssetList">
	@include('layouts.tableList')
</div>


@stop