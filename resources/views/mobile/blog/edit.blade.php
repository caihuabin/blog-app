@extends('mobile.layout.default')
@section('title')
{{ trans('view.Update Blog') }}_@parent
@stop

@section('header')
<header class="bar bar-nav">
  	<a id="updateBlog" href="javascript:;" class="btn btn-link btn-nav pull-right action_confirm" data-ignore="push">
    	<span class="icon icon-check"></span>{{ trans('view.OK') }}
  	</a>
		<h1 class="title">{{ trans('view.Update Blog') }}</h1>
</header>
@stop

@section('content')
<div class="content">
	<form id="blogForm" method='POST' action="{{route('blog.update',[$blog->id])}}">
		<input name="_method" value="PUT" type="hidden">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="table-view-divider">{{ trans('view.Article') }}</div>

        <div class="content-padded">
            <div class="input-row">
                <label for="contact">{{ trans('view.title') }}</label>
                <input type="text" name="title" value="{{ old('title') ? old('title') : $blog->title }}" required/>
            </div>
            <div class="content-padded">
                <textarea name="blog_body" rows="5">{{ old('blog_body') ? old('blog_body') : $blog->blog_body }}</textarea>
            </div>
        </div>

        <div id="image_list">
        	@if($blog->image_list && count($blog->image_list))
                @foreach($blog->image_list as $key => $image)
                <input type="hidden" name="image_list[{{$key}}]" value="{{ $image }}">
                @endforeach
            @endif
        </div>

	</form>

    <form method='POST' action="{{ route('upload_image_clip') }}" class="imageUploadForm" id="imageUploadForm" data-input="image_list" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="clip" value="240">
        <div class="table-view-divider">
            {{ trans('view.Upload Image') }}
            <div class="fileInputContainer micon-camera pull-right">
                <input class="fileInput" type="file" name="imagefile" id="imagefile"  accept="image/gif, image/jpeg, image/png,image/*;capture=camera" value=""/>
            </div>
        </div>
    </form>

    @if($blog->image_list && count($blog->image_list))
    <div class="content-padded">
        <div id="show_image" class="grid-g">
            @foreach($blog->image_list as $image)
            <div class="grid-u-1-3">
                <img class="img-responsive" alt="picture" src="{{ App\Blog\Helpers\ViewHelpers::getClipImageUrl($image) }}">
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
