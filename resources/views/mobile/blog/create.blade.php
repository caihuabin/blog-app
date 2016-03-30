@extends('mobile.layout.default')
@section('title')
{{ trans('view.Create Blog') }}_@parent
@stop

@section('header')
	<header class="bar bar-nav">
	  	<a id="createBlog" href="javascript:;" class="btn btn-link btn-nav pull-right action_confirm" data-ignore="push">
	    	<span class="icon icon-check"></span>{{ trans('view.OK') }}
	  	</a>
  		<h1 class="title">{{ trans('view.Create Blog') }}</h1>
	</header>
@stop

@section('content')
<div class="content">
	<form id="blogForm" method='POST' action="{{route('blog.store')}}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="table-view-divider">{{ trans('view.Article') }}</div>

        <div class="content-padded">
            <div class="input-row">
                <label for="contact">{{ trans('view.title') }}</label>
                <input type="text" name="title" value="{{old('title')}}" required/>
            </div>
            <div class="content-padded">
                <textarea name="blog_body" rows="5"></textarea>
            </div>
        </div>

        <div id="image_list"></div>

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
    <div class="content-padded">
            <div id="show_image" class="grid-g">
                
            </div>
        </div>
</div>
@endsection


