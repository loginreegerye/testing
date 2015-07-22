@extends('layout')

@section('page_title')
EDIT USER
@stop

@section('content')

@if (count($errors) > 0)
<div class="alert alert-danger">
	<strong>Whoops!</strong> There were some problems with your input.<br><br>
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading">
	USER INFO
	</div>
	<div class="panel-body">
		<table class="table-n table-u table-r">
			<thead>
				<tr>
					<th>#_ID</th>
					<th>NAME</th>
					<th>SURNAME</th>
					<th>EMAIL</th>
				</tr>
			</thead>
			<tbody>
			{!! Form::model($user, ['route' => ['user.update', $user->id, '_method' => 'PUT'] ]) !!}
				<tr>
					<td>{{ $user->id }}</td>
					<td>{!! Form::text('first_name', null, ['class' => 'form-control input-sm']) !!}</td>
					<td>{!! Form::text('last_name', null, ['class' => 'form-control input-sm']) !!}</td>
					<td>{!! Form::text('email', null, ['class' => 'form-control input-sm']) !!}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="panel-footer text-center">
		{!! Form::submit('SAVE', ['class' => 'btn btn-default']) !!}
		{!! Form::close() !!}
	</div>
</div>

@stop
