@extends('layout')

@section('page_title')
ADD USER
@stop

@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
	USERS LIST TO ADD
	</div>
	<div class="panel-body">
		<table class="table-u table-hover table-n">
			<thead>
				<tr>
					<th>#_ID</th>
					<th>NAME</th>
					<th>SURNAME</th>
					<th>EMAIL</th>
					<th>DUTY</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->first_name }}</td>
					<td>{{ $user->last_name }}</td>
					<td>{{ $user->email }}</td>
					<td>{{ $users->find($user->id)->books()->count() }}</td>
					<td>
					{!! Form::open(['url' => URL::current().'/'.$user->id]) !!}
					{!! Form::hidden('_method', 'PUT') !!}
					{!! Form::submit('ADD', ['class' => 'btn btn-default btn-xs']) !!}
					{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
	<div class="panel-footer">
	</div>
</div>

@stop
