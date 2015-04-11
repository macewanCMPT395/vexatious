@extends('layouts.header')

@section('headerScript')	
	{{ HTML::style('css/tableList.css') }}
	{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
	{{ HTML::style('css/users.css') }}
@stop

@section('content')
	     <div>
             @include('layouts.tableList')
             </div>
<script>
$(document).ready(function() {
	$('.table-static-header-row')
		.append($('<td></td>').text('Name'))
        	.append($('<td></td>').text('Email'))
        	.append($('<td></td>').text('Branch'))
		.append($('<td></td>').text('Admin Status'));
	
	});

var Users = {{ json_encode(User::All()) }};	
var Branches = {{ json_encode(Branch::lists('name','id')) }};
console.log(Users);

fillTable();

function fillTable() {
	var table = $('.table-rows-table');
	Users.forEach(function(User) {
		var row = document.createElement('tr');
		
		$(row).append($('<td></td>').text(User.firstName + User.lastName))
		      .append($('<td></td>').text(User.email))
		      .append($('<td></td>').text(Branches[User.branchID]));

		if(User.role == 1) {
		      $(row).append($('<td></td>').append($('<button>').attr('type','button').text('Remove Admin Status')));
		} else {
		      $(row).append($('<td></td>').append($('<button>').attr('type','button').text('Give Admin Status'))); 
		}
		table.append($(row));
		});
}
 
</script>
@stop

