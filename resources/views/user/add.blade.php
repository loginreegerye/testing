@extends('layout')

@section('page_title')
ADD BOOK
@stop

@section('content')

<div class="panel panel-default">
	<div class="panel-heading">
	AVAILABLE BOOKS TO ADD 
	</div>
	<div class="panel-body">
		<table class="table-u table-n table-hover">
			<thead>
				<tr>
					<th>#_ID</th>
					<th>TITLE</th>
					<th>AUTHOR</th>
					<th>YEAR</th>
					<th>GENRE</th>
					<th>AVAILABLE</th>
					<th>ACTION</th>
				</tr>
			</thead>
			<tbody>
			@foreach($books as $book)
				<tr>
					<td>{{ $book->id }}</td>
					<td>{{ $book->title }}</td>
					<td>{{ $book->author }}</td>
					<td>{{ $book->year }}</td>
					<td>{{ $book->genre }}</td>
					<td>{{ '+' }}</td>
					<td>
					{!! Form::open(['url' => URL::current().'/'.$book->id]) !!}
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
