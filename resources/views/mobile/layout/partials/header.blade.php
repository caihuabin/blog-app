<header class="bar bar-nav" id="pullHeader">
    <a href="#popover" class="icon icon-list pull-left"></a>
    @if(isset($currentUser))
    <a href="{{ url('auth/logout') }}" class="icon micon-export pull-right" data-ignore="push"></a>
    @else
    <a href="{{ url('auth/login') }}" class="icon icon-person pull-right" data-transition="slide-in"></a>
    @endif
    <h1 class="title">{{ trans('view.blog-app') }}</h1>
</header>