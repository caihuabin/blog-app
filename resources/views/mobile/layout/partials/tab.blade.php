<nav class="bar bar-tab">
    <a class="tab-item active" href="{{ route('blog.index') }}" data-transition="slide-out">
      	<span class="icon icon-pages"></span>
        <span class="tab-label">{{trans('view.blog')}}</span>
    </a>
    
    <a class="tab-item" href="{{ route('blog.create') }}" data-transition="slide-in">
        <span class="icon icon-compose"></span>
        <span class="tab-label">{{trans('view.public')}}</span>
    </a>
    @if(isset($currentUser))
    <a class="tab-item" href="{{ route('user.show', [$currentUser->id]) }}" data-transition="slide-in">
        <span class="icon icon-person"></span>
        <span class="badge">{{ $currentUser->notification_count }}</span>
        <span class="tab-label">{{trans('view.my')}}</span>
    </a>
    @else
    <a class="tab-item" href="{{ url('auth/login') }}" data-transition="slide-in">
        <span class="icon icon-person"></span>
        <span class="tab-label">{{trans('view.my')}}</span>
    </a>
    @endif
    <a class="tab-item" href="#">
        <span class="icon icon-star"></span>
        <span class="tab-label">{{trans('view.more')}}</span>
    </a>
</nav>