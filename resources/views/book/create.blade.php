@extends('layout')

@section('page_title')
CREATE BOOK
@stop

@section('content')

@if(Session::has('message'))
<div class="alert alert-info text-center">{{ Session::get('message') }}</div>
@endif

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
	CREATE BOOK
	</div>
	<div class="panel-body">
	{!! Form::open(['url' => 'book']) !!}
	<div class="form-group form-group-sm">
		{!! Form::text('title', Input::old('title'), ['class' => 'form-control', 'placeholder' => 'TITLE']) !!}
	</div>
	<div class="form-group form-group-sm">
		{!! Form::text('author', Input::old('author'), ['class' => 'form-control', 'placeholder' => 'AUTHOR']) !!}
	</div>
	<div class="form-group form-group-sm">
		{!! Form::text('year', Input::old('year'), ['class' => 'form-control', 'placeholder' => 'YEAR']) !!}
	</div>
	<div class="form-group form-group-sm">
		{!! Form::text('genre', Input::old('genre'), ['class' => 'form-control', 'placeholder' => 'GENRE']) !!}
	</div>
	<div class="form-group text-center">
		{!! Form::submit('CREATE', ['class' => 'btn btn-default']) !!}
	</div>
	{!! Form::close() !!}
	</div>
	<div class="panel-footer text-center">
	</div>
</div>

@stop
