@extends('mobile.layout.default')
@section('title')
    {{ trans('view.Home') }}_@parent
@stop

@section('header')
	@include('mobile.layout.partials.header')
@stop

@section('content')
<div class="content"  id="pullContent">
	<div class="slider">
        <div class="slide-group">
            <div class="slide">
                <img src="{{ asset('mobile/image/slide1.jpg') }}" alt="pic" width="100%" height="">
                <span class="slide-text">
                    <span class="icon icon-left-nav"></span>
                    Slide me
                </span>
                <span class="slide-desc">........welcome..........</span>
            </div>
            <div class="slide">
                <img src="{{ asset('mobile/image/slide2.jpg') }}" alt="pic" width="100%" height="">
                <span class="slide-desc">........welcome......welcome........</span>
            </div>
            <div class="slide">
               <img src="{{ asset('mobile/image/slide3.jpg') }}" alt="pic" width="100%" height="">
            </div>
        </div>
    </div>

@if(isset($blogs))
    @include('mobile.layout.partials.blog')
@endif
</div>
@stop

