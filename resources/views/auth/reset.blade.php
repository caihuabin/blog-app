@extends('mobile.layout.default')
@section('title')
{{ trans('view.Reset') }}_@parent
@stop

@section('header')
<header class="bar bar-nav">
  	<h1 class="title">{{ trans('view.Reset') }}</h1>
</header>
@stop

@section('content')
<div class="content">
	<div class="content-padded">
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		<form method="POST" action="{{url('password/reset')}}">
	        <input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="token" value="{{ $token }}">

		  	<input type="hidden" name="email" value="{{ old('email') }}">
		  	<input type="password" name="password">
	        <input type="password" name="password_confirmation">
		  	<button type="submit" class="btn btn-positive btn-block">{{ trans('view.Reset') }}</button>
		</form>
	</div>
</div>
@endsection