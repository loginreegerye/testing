@extends('layout')

@section('page_title')
ALL BOOKS
@stop

@section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
	ALL BOOKS
	</div>
	<div class="panel-body">
		<table class="table-n table-hover">
			<thead>
				<tr>
					<th>TITLE</th>
					<th>AUTHOR</th>
					<th>YEAR</th>
					<th>AVAILABLE</th>
				</tr>
			</thead>
			<tbody>
			@foreach($books as $book)
			<tr>
				<td><a href="{{ URL::to('book/'.$book->id) }}" class="row-a">{{ $book->title }}</a></td>
				<td><a href="{{ URL::to('book/'.$book->id) }}" class="row-a">{{ $book->author }}</a></td>
				<td><a href="{{ URL::to('book/'.$book->id) }}" class="row-a">{{ $book->year }}</a></td>
				<td><a href="{{ URL::to('book/'.$book->id) }}" class="row-a">@if($book->user_id !== 0) {{ '-' }} @else {{ '+' }} @endif</a></td>
			</tr>
			@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan = "4">{!! $books->render() !!}</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="panel-footer text-center">
	</div>
</div>

@stop
