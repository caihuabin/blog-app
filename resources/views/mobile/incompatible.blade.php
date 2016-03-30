<!DOCTYPE html>
<html style="background:#EEEEEE">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    	<title>{{ trans('view.Sorry, it is incompatible.') }}</title>
    	<meta name="keywords" content="{{ isset($keywords) ? $keywords : trans('view.keywords') }}" />
		<meta name="author" content="{{ isset($author) ? $author : trans('view.author') }}" />
		<meta name="description" content="@section('description') {{ trans('view.Description') }}@show" />
		
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('mobile/image/logo.png') }}" media="screen">

    	<link href="{{ asset('mobile/css/static.css') }}" media="screen" rel="stylesheet" type="text/css"> 
	</head>

	<body>
		<header id="welcome">
			<h1>Oh,no</h1>
		</header>
		<section>
			<h3>{{ trans('view.Sorry, it is incompatible.') }}</h3>
			<hr>
			<p style="font-size:16px;">{{ trans('view.It is incompatible.We note:') }}</p>
			<a href="{{url('/')}}">点击返回主站</a>
		</section>
		<footer id="info">
		    <p>Originated by <a href="https://github.com/icyse">Cai</a></p>
		    <p>Modified by <a href="https://github.com/icyse">Cai</a> in March 2016</p>
		</footer>
	</body>
</html>