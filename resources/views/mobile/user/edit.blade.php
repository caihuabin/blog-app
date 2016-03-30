@extends('mobile.layout.default')
@section('title')
{{ trans('view.Edit Userinfo') }}_@parent
@stop

@section('header')
	<header class="bar bar-nav">
        <a href="{{ route('user.show', [$currentUser->id]) }}" class="btn btn-link btn-nav pull-left" data-transition="slide-out">
    	<span class="icon icon-left-nav"></span>
    	{{ trans('view.Back') }}
	  	</a>
  		<h1 class="title">{{ trans('view.Edit Userinfo') }}</h1>
	</header>
@stop

@section('content')
<div class="content">
	<form method='POST' action="{{ route('upload_image_clip') }}" class="imageUploadForm" id="imageUploadForm" data-input="avatar" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="clip" value="240">
        <div class="table-view-divider">
            {{ trans('view.Avatar') }}
            <div class="fileInputContainer micon-camera pull-right">
                <input class="fileInput" type="file" name="imagefile" id="imagefile"  accept="image/gif, image/jpeg, image/png,image/*;capture=camera" value=""/>
            </div>
        </div>
        <div class="table-view-cell media">
            <div id="show_image" class="media-object pull-left" style="width:96px;">
                <div>
                    <img src="{{ $user->avatar }}" width="64" alt="">
                </div>
            </div>
            <div class="media-body">
            </div>
        </div>
    </form>

    <form id="userinfoForm" method='POST' action="{{route('user.update',[$user->id])}}">
        <input name="_method" value="PUT" type="hidden">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="hidden" name="avatar" id="avatar" value="{{ $user->avatar }}">

        <div class="table-view-divider">{{ trans('view.Information') }}</div>
        <div class="content-padded">
            <div class="input-row">
                <label for="name">{{ trans('view.Name') }}</label>
                <input type="text" name="name" required disabled="disabled" value="{{ $user->name }}" placeholder="">
            </div>
            <div class="input-row">
                <label for="realname">{{ trans('view.Realname') }}</label>
                <input type="text" name="realname" value="{{ $user->realname }}" placeholder="{{ trans('view.Realname') }}" />
            </div>
            <div class="input-row">
                <label for="city">{{ trans('view.City') }}</label>
                <input type="text" name="city"  value="{{ $user->city }}">
            </div>
            <div class="input-row">
                <label for="address">{{ trans('view.Address') }}</label>
                <input type="text" name="address"  value="{{ $user->address }}">
            </div>
            <div class="input-row">
                <label for="signature">{{ trans('view.Signature') }}</label>
                <input type="text" name="signature" value="{{ $user->signature }}">
            </div>
        </div>

        <div class="table-view-divider">{{ trans('view.Personal Information') }}</div>
        <div class="content-padded">
            <div class="input-row">
                <label for="gender">{{ trans('view.Gender') }}</label>
                <div id="genderToggle" class="toggle {{$user->gender ? '' : 'active'}}">
                    <div class="toggle-handle"></div>
                </div>
                <input type="hidden" name="gender" value="{{$user->gender ? 1 : 0}}">
            </div>
            <div class="input-row">
                <label for="telephone">{{ trans('view.Telephone') }}</label>
                <input type="tel" name="telephone" value="{{ $user->telephone }}" placeholder="{{ trans('view.Telephone') }}" />
            </div>
	  	</div>
        <div class="content-padded">
            <input type="submit" class="btn btn-block btn-positive" value="{{ trans('view.Save') }}">
        </div>
	</form>

</div>
@endsection
