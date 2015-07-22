@extends('layout')

@section('page_title')
ALL USERS
@stop

@section('content')

<div class="panel panel-default">
	<div class="panel-heading text-center">
	ALL USERS
	</div>
	<div class="panel-body">
		<table class="table-n table-hover">
			<thead>
				<tr>
					<th>NAME</th>
					<th>SURNAME</th>
					<th>DUTY</th>
				</tr>
			</thead>
			<tbody>
			@foreach($users as $user)
			<tr>
				<td><a href="{{ URL::to('user/'.$user->id) }}" class="row-a">{{ $user->first_name }}</a></td>
				<td><a href="{{ URL::to('user/'.$user->id) }}" class="row-a">{{ $user->last_name }}</a></td>
				<td><a href="{{ URL::to('user/'.$user->id) }}" class="row-a">{{ $users->find($user->id)->books()->count() }}</a></td>
			</tr>
			@endforeach
			</tbody>
			<tfoot>
				<tr>
					<td colspan = "3">{!! $users->render() !!}</td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div class="panel-footer text-center">
	</div>
</div>

@stop
