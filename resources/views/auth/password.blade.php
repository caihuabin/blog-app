@extends('mobile.layout.default')
@section('title')
{{ trans('view.Get Back') }}_@parent
@stop

@section('header')
<header class="bar bar-nav">
  	<a href="{{url('auth/login')}}" class="btn btn-link btn-nav pull-left" data-transition="slide-out">
    	<span class="icon icon-left-nav"></span>
    	{{ trans('view.Login') }}
  	</a>
  	<a href="{{url('auth/register')}}" class="btn btn-link btn-nav pull-right" data-transition="slide-in">
    	{{ trans('view.Register') }}<span class="icon icon-right-nav"></span>
  	</a>
  	<h1 class="title">{{ trans('view.Get Back') }}</h1>
</header>
@stop

@section('content')
<div class="content">
	<div class="content-padded">
		@if (session('status'))
			<div class="alert alert-success">
				{{ session('status') }}
			</div>
		@endif
		@if (count($errors) > 0)
			<div class="alert alert-danger">
				<ul>
					@foreach ($errors->all() as $error)
						<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
		@endif
		<form method="POST" action="{{url('password/email')}}">
	        <input type="hidden" name="_token" value="{{ csrf_token() }}">

		  	<input type="email" name="email" value="{{ old('email') }}" placeholder="{{ trans('view.Email') }}">
		  	<button type="submit" class="btn btn-negative btn-block">{{ trans('view.Get Back') }}</button>
		</form>
	</div>
</div>
@stop