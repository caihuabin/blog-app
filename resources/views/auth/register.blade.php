@extends('mobile.layout.default')
@section('title')
{{ trans('view.Register') }}_@parent
@stop
@section('header')
<header class="bar bar-nav">
  	<a href="{{url('auth/login')}}" class="btn btn-link btn-nav pull-left" data-transition="slide-out">
    	<span class="icon icon-left-nav"></span>
    	{{trans('view.Login')}}
  	</a>
  	<h1 class="title">{{trans('view.Register')}}</h1>
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
	<form method="POST" action="{{url('auth/register')}}">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="text" name="name" value="{{ old('name') }}" placeholder="{{ trans('view.Name') }}">
	  	<input type="email" name="email" value="{{ old('email') }}" placeholder="{{ trans('view.Email') }}">
	  	<div style="position:relative;">
            <input type="password" name="password" style="padding-right:30px;" placeholder="{{ trans('view.Password') }}" />
            <span class="micon-eye" style="position:absolute;top: 5px;right: 0;" onclick="this.classList.toggle('micon-eye');this.classList.toggle('micon-eye-off');var input = this.parentNode.children[0];input.getAttribute('type') == 'text' ? input.setAttribute('type', 'password') : input.setAttribute('type', 'text'); "></span>
        </div>
	  	<div style="position:relative;">
	  		<input type="password" name="password_confirmation" placeholder="{{ trans('view.Password Confirm') }}" />
	  		<span class="micon-eye" style="position:absolute;top: 5px;right: 0;" onclick="this.classList.toggle('micon-eye');this.classList.toggle('micon-eye-off');var input = this.parentNode.children[0];input.getAttribute('type') == 'text' ? input.setAttribute('type', 'password') : input.setAttribute('type', 'text'); "></span>
	  	</div>
	  	<button type="submit" class="btn btn-primary btn-block">{{trans('view.Register')}}</button>
	</form>
</div>
</div>
@stop