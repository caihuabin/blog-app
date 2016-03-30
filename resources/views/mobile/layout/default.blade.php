<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title> 
			@section('title') 
				{{ trans('view.blog-app') }}
			@show 
		</title>
		<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    	<meta name="apple-mobile-web-app-capable" content="yes">
    	<meta name="apple-mobile-web-app-status-bar-style" content="black">

    	<meta name="keywords" content="{{ isset($keywords) ? $keywords : trans('view.keywords') }}" />
		<meta name="author" content="{{ isset($author) ? $author : trans('view.author') }}" />
		<meta name="description" content="@section('description') {{ trans('view.description') }}@show" />
		
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('mobile/image/logo.png') }}" media="screen">

		<script>
	        Config = {
	            'user_hash': '{{ isset( $currentUser ) ? $currentUser->id : 0 }}',
	            'token': '{{ csrf_token() }}',
	            'routes': {
	            	'upload_image_url' : '{{ route('upload_image_clip') }}'
	            }
	        };
	    </script>
        <link rel="stylesheet" href="{{ asset('mobile/fontello/css/fontello.css') }}">
		<link rel="stylesheet" href="{{ asset('mobile/css/carte-0.1.min.css') }}">
		<link rel="stylesheet" href="{{ asset('mobile/css/app.css') }}">
	</head>
	<body>
	    @yield('header')
		@include('mobile.layout.partials.tab')
		@yield('standar')
		@yield('content')
		@include('mobile.layout.partials.popover')
		<script src="{{ asset('mobile/js/jquery-2.1.4.min.js') }}"></script>
        <script src="{{ asset('mobile/js/carte-0.1.min.js') }}"></script>
		<script src="{{ asset('mobile/js/app.js') }}"></script>
	</body>
</html>
