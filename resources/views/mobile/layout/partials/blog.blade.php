<ul class="table-view">

    @foreach($blogs as $blog)
    <li class="table-view-cell table-view-divider">
        {{ trans('view.Blogger') }}：<strong class="author">{{ $blog->user->name }}</strong>  
        <span class="pull-right" style="font-size: 12px;">{{ date('Y-m-d l', strtotime($blog->created_at) ) }}</span>
    </li>
    <li class="table-view-cell media">
        <a class="navigate-right" href="{{route('blog.show', [$blog->id])}}" data-transition="slide-in">
            <img class="media-object pull-left img-responsive img-box" width="64" src="{{  $blog->user->avatar }}" alt="">
            <div class="media-body">
                @if(!$blog->is_excellent)
                <span class="badge badge-primary" style="position: absolute;right: 5px;">{{trans('view.Excellent')}}</span>
                @endif
                <!-- <span class="badge badge-positive pull-right"></span> -->
                @if($blog->view_count < 50)
                <span class="badge badge-negative" style="position: absolute;right: 35px;">{{trans('view.Hot')}}</span>
                @endif
                <div>
                    <div class="text-ellipsis">{{ $blog->title }}</div>
                    <p style="font-size: 12px;">
                        <span class="timeago" >{{ $blog->updated_at }}</span>{{trans('view.update')}}
                    </p>
                </div>
                <div>
                    <span><i class="micon-eye md-micon"></i>{{ $blog->view_count }}</span>
                    <span><i class="micon-comment-empty md-micon"></i>{{ $blog->reply_count }}</span>
                    <span><i class="micon-thumbs-up md-micon"></i>{{ $blog->vote_count }}</span>
                </div>
            </div>
            
            <div class="media-footer">
                
            </div>
        </a>
    </li>
    @endforeach
</ul>
<?php echo $blogs->render(); ?>