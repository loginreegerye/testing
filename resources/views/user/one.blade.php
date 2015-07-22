@extends('layout')

@section('page_title')
USER
@stop

@section('content')

@if(Session::has('message'))
<div class="alert alert-info text-center">{{ Session::get('message') }}</div>
@endif

<div class="panel panel-default">
	<div class="panel-heading text-center">
	USER INFO
	</div>
	<div class="panel-body">
		<table class="table-n table-hover table-u">
			<thead>
				<tr>
					<th>#_ID</th>
					<th>NAME</th>
					<th>SURNAME</th>
					<th>EMAIL</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>{{ $user->id }}</td>
					<td>{{ $user->first_name }}</td>
					<td>{{ $user->last_name }}</td>
					<td>{{ $user->email }}</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="panel-footer">
		<a class="btn btn-default" href="{{ URL::current().'/edit' }}">EDIT</a>
		{!! Form::open(['url' => URL::current(), 'class' => 'pull-right']) !!}
		{!! Form::hidden('_method', 'DELETE') !!}
		{!! Form::submit('DELETE', ['class' => 'btn btn-default']) !!}
		{!! Form::close() !!}
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading text-center">
	THIS USER BOOKS
	</div>
	<div class="panel-body">
		<table class="table-n table-hover table-u">
			<thead>
				<tr>
					<th>#_ID</th>
					<th>TITLE</th>
					<th>AUTHOR</th>
					<th>YEAR</th>
					<th>GENRE</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
			@if(isset($empty))
				<tr>
				<td colspan="6">{{ $empty }}</td>
				</tr>
			@else
			@foreach($books as $book)
				<tr>
					<td>{{ $book->id }}</td>
					<td>{{ $book->title }}</td>
					<td>{{ $book->author }}</td>
					<td>{{ $book->year }}</td>
					<td>{{ $book->genre }}</td>
					<td>
					{!! Form::open(['url' => URL::current().'/del/'.$book->id]) !!}
					{!! Form::hidden('_method', 'DELETE') !!}
					{!! Form::submit('DELETE', ['class' => 'btn btn-default btn-xs']) !!}
					{!! Form::close() !!}
					</td>
				</tr>
			@endforeach
			@endif
			</tbody>
		</table>
	</div>
	<div class="panel-footer text-center">
		<a class="btn btn-default" href="{{ URL::current().'/add' }}">ADD</a>
	</div>
</div>
@stop