@extends('mobile.layout.default')
@section('title')
{{ trans('view.my') }}_@parent
@stop

@section('header')
    <header class="bar bar-nav">
        <a href="{{ route('home') }}" class="btn btn-link btn-nav pull-left" data-transition="slide-out">
        <span class="icon icon-home"></span>{{trans('view.Home')}}
        </a>
        @if(isset($currentUser) && $currentUser->id == $user->id)
        <a href="{{ route('user.edit', [$user->id]) }}" class="btn btn-link btn-nav pull-right" data-transition="slide-in">
            <span class="icon icon-edit"></span>{{trans('view.Edit')}}
        </a>
        @endif
        <h1 class="title">User</h1>
    </header>
@stop

@section('content')
<div class="content">
    <ul class="table-view">
        <li class="table-view-cell media">
            <img class="media-object pull-left" src="{{ $user->avatar }}" width="64">
            <div class="media-body">
                <div class="submite">{{ $user->name }}</div>
                <p class="text-ellipsis">{{trans('view.Email')}}：{{$user->email}}</p>
            </div>
        </li>
        <li class="table-view-divider">{{trans('view.Information')}}</li>
        <li class="table-view-cell">
            <label>{{ trans('view.Realname') }}</label>
            <span style="padding-left:2em;color:gray">{{ $user->realname ? $user->realname : '...' }}</span>
        </li>
        <li class="table-view-cell">
            <label>{{ trans('view.Address') }}</label>
            <span style="padding-left:2em;color:gray;">{{ $user->city ? $user->city : '...' }}</span>
            <span style="padding-left:1em;color:gray;">{{ $user->address ? $user->address : '...' }}</span>
        </li>
        <li class="table-view-cell">
            <label>{{ trans('view.Signature') }}</label>
            <span style="padding-left:2em;color:gray">{{ $user->signature ? $user->signature : '...' }}</span>
        </li>
        <li class="table-view-cell">
            <label>{{ trans('view.Register Time') }}</label>
            <span style="padding-left:2em;color:gray">{{ $user->created_at->toFormattedDateString() }}</span>
        </li>

        @if($user->id == $currentUser->id)
        <li class="table-view-divider">{{trans('view.Personal Information')}}</li>
        <li class="table-view-cell">
            <label>{{ trans('view.Gender') }}</label>
            <span style="padding-left:2em;color:gray;">{{ $user->gender ? trans('view.male') : trans('view.female') }}</span>
        </li>
        <li class="table-view-cell">
            <label>{{ trans('view.Telephone') }}</label>
            <span style="padding-left:1em;color:gray;">{{ $user->telephone ? $user->telephone : '...' }}</span>
        </li>

        <li class="table-view-divider">{{trans('view.Dynamic')}}</li>
        <li class="table-view-cell media">
            <a href="{{ route('notification.show', [$user->id]) }}" class="navigate-right" data-transition="slide-in">
                <span class="media-object pull-left icon icon-sound"></span>
                <div class="media-body">
                    {{trans('view.New notification')}}
                </div>
                <span class="badge badge-negative">{{ $user->notification_count }}</span>
            </a>
        </li>

        <li class="table-view-cell media">
            <a href="{{url('auth/logout')}}" data-ignore="push">
                <span class="media-object pull-left micon-export"></span>
                <div class="media-body">
                    {{trans('view.Logout')}}
                </div>
            </a>
        </li>
        @endif
    </ul>
    
</div>
@stop
