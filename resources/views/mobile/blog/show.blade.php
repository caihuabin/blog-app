@extends('mobile.layout.default')
@section('title')
{{ trans('view.Article') }}_@parent
@stop
@section('header')
<header class="bar bar-nav">
    <a href="{{ route('home') }}" class="btn btn-link btn-nav pull-left" data-transition="slide-out">
    <span class="icon icon-home"></span>{{trans('view.Home')}}
    </a>
    @if(isset($currentUser) && $currentUser->id == $blog->user_id)
    <a href="{{ route('blog.edit', [$blog->id]) }}" class="btn btn-link btn-nav pull-right" data-transition="slide-in">
        <span class="icon icon-edit"></span>{{trans('view.Edit')}}
    </a>
    @endif
    <h1 class="title">{{ trans('view.Article') }}</h1>
</header>
@stop
@section('content')
<div class="content">
    <ul class="table-view">
        <li class="table-view-cell media">
            <img class="media-object pull-left img-responsive" width="64" src="{{ $blog->user->avatar }}" alt="no image,can talk">
            <div class="media-body">
                <div class="text-ellipsis">{{ $blog->title }}</div>
            </div>
            <div class="media-desc">
                <a href="{{ route('user.show', [$blog->user_id]) }}" class="author">
                    {{ $blog->user->name }}
                </a>
                <span class="timeago">{{ $blog->created_at }}</span>
            </div>
            <div class="media-like">
                <a class="reply" href="javascript:void(0);" onclick="Blog.replyBlog();"><i class="micon-reply mini-micon"></i>{{ trans('view.Reply') }}</a>
                <a href="javascript:void(0);" data-method="post" data-token="{{ csrf_token() }}" data-url="{{ route('blog.vote', $blog->id) }}" title="{{ trans('view.Vote') }}" class="vote"><i class="micon-thumbs-up pure-micon"></i> {{ $blog->vote_count }} </a>
                @if(isset($currentUser) && $currentUser->id == $blog->user_id)
                <a href="javascript:void(0);" class="delete action_confirm" data-method="delete" data-token="{{ csrf_token() }}" data-url="{{ route('blog.destroy', $blog->id) }}" title="{{ trans('view.Delete') }}"><i class="micon-block pure-micon"></i>{{ trans('view.Delete') }}</a>
                @endif
            </div>

            <div class="media-footer">
                <p>{{ $blog->blog_body }}</p>
            </div>
        </li>
    </ul>
    @if($blog->image_list && count($blog->image_list))
    <div class="cardbox">
        <div class="grid-g">
            @foreach($blog->image_list as $image)
            <div class="grid-u-1-3">
                <a data-imagelightbox="a" href="{{$image}}" data-ignore="push">
                    <img class="img-responsive" alt="picture" src="{{ App\Blog\Helpers\ViewHelpers::getClipImageUrl($image) }}">
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    <div class="table-view-divider">{{ trans('view.Reply') }}: {{ $blog->reply_count }}</div>
    <div class="content-padded">
        <div class="ui comments">
            @foreach($replies as $reply)
            <div class="comment">
                <a class="avatar">
                    <img src="{{ $reply->user->avatar }}">
                </a>
                <div class="content">
                    <a class="author">{{ $reply->user->name }}</a>
                    <div class="metadata">
                        <span class="date timeago">{{ $reply->created_at }}</span>
                    </div>
                    <div class="text">{{ $reply->reply_body }}</div>
                    <div class="actions">
                        <a class="reply" href="javascript:void(0);" onclick="Blog.replyOne('{{ $reply->user->name }}', '{{ $reply->id }}');"><i class="micon-reply mini-micon"></i>{{ trans('view.Reply') }}</a>
                        <a class="vote" data-method="post" href="javascript:void(0);" data-token="{{ csrf_token() }}" data-url="{{ route('reply.vote', $reply->id) }}" title="{{ trans('view.Vote') }}"><i class="micon-thumbs-up mini-micon"></i>{{ trans('view.Vote Count', ['count' => $reply->vote_count]) }}</a>
                    </div>
                </div>
                @if(isset($reply->replys) && $reply->replys)
                    @foreach($reply->replys as $replyChild)
                    <div class="comments">
                        <div class="comment">
                            <a class="avatar">
                                <img src="{{ $replyChild->user->avatar }}">
                            </a>
                            <div class="content">
                                <a class="author">{{ $replyChild->user->name }}</a>
                                <div class="metadata">
                                    <span class="date timeago">{{ $replyChild->created_at }}</span>
                                </div>
                                <div class="text">{{ $replyChild->reply_body }}</div>
                                <div class="actions">
                                    <a class="reply" href="javascript:void(0);" onclick="Blog.replyOne('{{ $replyChild->user->name }}', '{{ $reply->id }}');"><i class="micon-reply mini-micon"></i>{{ trans('view.Reply') }}</a>
                                    <a class="vote" data-method="post" href="javascript:void(0);" data-token="{{ csrf_token() }}" data-url="{{ route('reply.vote', $replyChild->id) }}" title="{{ trans('view.Vote') }}"><i class="micon-thumbs-up mini-micon"></i>{{ trans('view.Vote Count', ['count' => $replyChild->vote_count]) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
            @endforeach
            <?php echo $replies->render(); ?>
            <form class="ui reply form" id="replyForm" method='POST' action="{{route('reply.store')}}" >
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="blog_id" value="{{ $blog->id }}" readonly="readonly" />
                <input type="hidden" name="reply_id" value="0" id="reply_id" />
                <div class="field">
                @if(isset($currentUser) )
                    <textarea id="reply_content" name="reply_body" rows="3" placeholder="{{ trans('view.please reply:') }}"></textarea>
                    <input type="submit" class="btn btn-primary btn-block" value="{{ trans('view.Save') }}">
                @else
                    <textarea id="reply_content" name="reply_body" rows="3" placeholder="{{ trans('view.need login to reply:') }}" disabled="disabled"></textarea>
                    <input type="submit" class="btn btn-primary btn-block" value="{{ trans('view.Save') }}" disabled="disabled">
                @endif
                </div>
            </form>

        </div>
    </div>
</div>
@endsection