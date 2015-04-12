@extends('layouts.header')

@section('headerScript')	
	{{ HTML::script('fullcalendar/lib/jquery.min.js') }}
	{{ HTML::style('css/users.css') }}
	{{ HTML::style('css/tableList.css') }}
	{{ HTML::style('css/tableFilter.css') }}
	<script>
	$(document).ready(function() {
		var Users = {{ json_encode(User::All()) }};	
		var Branches = {{ json_encode(Branch::lists('name','id')) }};
		
		$('#branch').prepend('<option value="0">All</option>');
		$('#branch').val(0);
		
		
		function filterUsers() {
			//first, only grab the bookings for the current branch
			var filterUsers = Users.filter(function(user) {
				var branchID = $('#branch').val();

				return (branchID == 0 || (user.branchID == branchID));
				
			});


			return filterUsers;
		}			
		
		
		
		$('.table-static-header-row')
			.append($('<td></td>').text('Name'))
				.append($('<td></td>').text('Email'))
				.append($('<td></td>').text('Branch'))
			.append($('<td></td>').text('Admin Status'));

		var form = '{{ Form::open(['method' => 'put', 'id' => 'id' , 'route' => ['users.update']])}}{{Form::close()}}'


		console.log(Users);

		fillTable();

		function fillTable() {
			var table = $('.table-rows-table');
			table.empty();
			var users = filterUsers();

			users.forEach(function(User) {
				var row = document.createElement('tr');
				var NewForm = form.replace('%7Busers%7D', User.id);
				var NewForm = NewForm.replace('"id"', User.id);
				$(row).append($('<td></td>').text(User.firstName + User.lastName))
					  .append($('<td></td>').text(User.email))
					  .append($('<td></td>').text(Branches[User.branchID]));

				if(User.role == 1) {
					  $(row).append($('<td></td>')
						.html($(NewForm))
						.append($('<button>').attr('type','button').text('Remove Admin Status')
						.on('click',function() {
						$('#' + User.id).submit();
								   })));
				} else {
					  $(row).append($('<td></td>')
						.html($(NewForm))
						.append($('<button>').attr('type','button').attr('id',User.id).text('Give Admin Status')
						.on('click',function() {
						$('#' + User.id).submit();
								   }))); 
				}
				table.append($(row));
				});
		}

		$('#branch').change(fillTable);
	});
	</script>

@stop
@section('editusersli') class="active" @stop
@section('content')
	<ul class="TableFilter-Bar">
		<li class="TableFilter-Content">
		{{ Form::label('branch', 'Branch') }}
		{{ Form::select('branch', Branch::lists('name', 'id')); }}
		</li>
	</ul>
	<div class="table-title-header">
		<div>Edit User Status</div>
	</div>
	<div id="usersTable">
		@include('layouts.tableList')
	</div>
@stop

