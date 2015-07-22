@extends('layout')

@section('page_title')
CREATE USER
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
	CREATE USER
	</div>
	<div class="panel-body">
	{!! Form::open(['url' => 'user']) !!}
	<div class="form-group form-group-sm">
		{!! Form::text('name', Input::old('name'), ['class' => 'form-control', 'placeholder' => 'NAME']) !!}
	</div>
	<div class="form-group form-group-sm">
		{!! Form::text('surname', Input::old('surname'), ['class' => 'form-control', 'placeholder' => 'SURNAME']) !!}
	</div>
	<div class="form-group form-group-sm">
		{!! Form::text('email', Input::old('email'), ['class' => 'form-control', 'placeholder' => 'EMAIL']) !!}
	</div>
	<div class="form-group form-group-sm">
		{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'PASSWORD']) !!}
	</div>
	<div class="form-group form-group-sm">
		{!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'CONFIRM PASSWORD']) !!}
	</div>
	<div class="form-group form-group-sm">
		<div class="radio">
			<label>
				<input type="radio" name="role" value="user" checked>
				USER
			</label>
		</div>
		<div class="radio">
			<label>
				<input type="radio" name="role" value="admin">
				ADMIN
			</label>
		</div>
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
