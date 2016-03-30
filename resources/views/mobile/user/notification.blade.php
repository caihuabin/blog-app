@extends('mobile.layout.default')
@section('title')
{{ trans('view.New Dynamic') }}_@parent
@stop

@section('header')
    @include('mobile.layout.partials.header')
@stop

@section('content')

<div class="content">
    <div class="content-padded">
    @if(count($notifications))
        <div class="ui feed">
        @foreach($notifications as $notification)
            <div class="event">
                <div class="label">
                    <img src="{{ $notification->fromUser->avatar }}">
                </div>
                <div class="content">
                    <div class="summary">
                        <a class="user">{{ $notification->fromUser->name }}</a>
                        {{ App\Blog\Presenters\NotificationPresenter::lableUp($notification->type) }}
                        <div class="date timeago">{{ $notification->created_at }}</div>
                    </div>
                    @if($notification->type == 'new_blog' && count($notification->blog->image_list))
                    <div class="extra images">
                        @foreach($notification->service->image_list as $image)
                        <a><img src="{{ $image }}"></a>
                        @endforeach
                    </div>
                    @elseif( in_array($notification->type, ['new_reply', 'at']) )
                    <div class="extra text">{{ $notification->noti_body }} </div>
                    @endif
                    <div class="meta">
                        <a href="{{ route('blog.show', [$notification->blog->id]) }}" class="like" data-transition="slide-in"><i class="micon-eye md-micon"></i>{{ trans('view.View') }}</a>
                        <a href="javascript:void(0);" class="delete action_confirm" data-method="delete" data-token="{{ csrf_token() }}" data-url="{{ route('notification.destroy', $notification->id) }}" title="{{ trans('view.Delete') }}"><i class="micon-block md-micon"></i>{{ trans('view.Delete') }}</a>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    @endif
    </div>
</div>
@stop
