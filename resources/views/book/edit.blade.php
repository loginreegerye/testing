@extends('layout')

@section('page_title')
BOOK EDIT
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
	<div class="panel-heading text-center">
	BOOK INFO
	</div>
	<div class="panel-body">
		<table class="table-n table-u table-r">
			<thead>
				<tr>
					<th>#_ID</th>
					<th>TITLE</th>
					<th>AUTHOR</th>
					<th>YEAR</th>
					<th>GENRE</th>
				</tr>
			</thead>
			<tbody>
			{!! Form::model($book, ['route' => ['book.update', $book->id, '_method' => 'PUT'] ]) !!}
				<tr>
					<td>{{ $book->id }}</td>
					<td>{!! Form::text('title', null, ['class' => 'form-control input-sm']) !!}</td>
					<td>{!! Form::text('author', null, ['class' => 'form-control input-sm']) !!}</td>
					<td>{!! Form::text('year', null, ['class' => 'form-control input-sm']) !!}</td>
					<td>{!! Form::text('genre', null, ['class' => 'form-control input-sm']) !!}</td>
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
