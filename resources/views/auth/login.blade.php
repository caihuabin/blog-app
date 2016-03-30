@extends('mobile.layout.default')
@section('title')
{{ trans('view.login') }}_@parent
@stop

@section('header')
<header class="bar bar-nav">
    <a href="{{url('password/email')}}" class="btn btn-link btn-nav pull-left" data-transition="slide-out">
    	<span class="icon icon-refresh"></span>
    	{{trans('view.Forget')}}
  	</a>
  	<a href="{{url('auth/register')}}" class="btn btn-link btn-nav pull-right" data-transition="slide-in">
    	{{trans('view.Register')}}<span class="icon icon-right-nav"></span>
  	</a>
  	<h1 class="title">{{trans('view.Login')}}</h1>
</header>
@stop
@section('standar')
<div class="bar bar-standard bar-header-secondary">
    <div class="segmented-control">
        <a class="control-item active" href="#login-form">
            <span class="tab-label">现在登录</span>
        </a>
        <a class="control-item" href="#login-type">
            <span class="tab-label">其他方式</span>
        </a>
    </div>
</div>
@stop
@section('content')
<div class="content">
    <div class="content-padded">
        <div class="control-content active" id="login-form">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{url('auth/login')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="remember" value="1">
                <input type="email" name="email" value="{{ old('email') }}" placeholder="{{ trans('view.Email') }}"/>
                <div style="position:relative;">
                    <input type="password" name="password" style="padding-right:30px;" placeholder="{{ trans('view.Password') }}"/>
                    <span class="micon-eye" style="position:absolute;top: 5px;right: 0;" onclick="this.classList.toggle('micon-eye');this.classList.toggle('micon-eye-off');var input = this.parentNode.children[0];input.getAttribute('type') == 'text' ? input.setAttribute('type', 'password') : input.setAttribute('type', 'text'); "></span>
                </div>
                <button type="submit" class="btn btn-positive btn-block">{{trans('view.Sign In')}}</button>
            </form>
        </div>
        
        <div class="control-content" id="login-type">
            <section class="login-area">
                <fieldset>
                    <legend>使用其他账号登录</legend>
                    <div class="login-btn-list">
                        <a href="#" class="bs-btn bs-btn-block bs-btn-social bs-btn-lg bs-btn-weibo"><i class="micon-weibo"></i>微博登录</a>
                        <a href="#" class="bs-btn bs-btn-block bs-btn-social bs-btn-lg bs-btn-qq"><i class="micon-qq"></i>QQ登录</a>
                        <a href="#" class="bs-btn bs-btn-block bs-btn-social bs-btn-lg bs-btn-weixin"><i class="micon-wechat"></i>微信登录</a>
                    </div>
                </fieldset>
            </section>
        </div>
    </div>
</div>
@stop