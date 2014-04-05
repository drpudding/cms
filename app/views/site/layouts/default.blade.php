<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	{{-- Always force latest IE rendering engine (even in intranet) & Chrome Frame --}}
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	{{-- SEO --}}
	<meta name="keywords" content="@yield('keywords', 'default goes here')">
	<meta name="author" content="@yield('author', 'default goes here')">
	<meta name="description" content="@yield('description', 'default goes here')">
	{{-- Dublin Core Metadata : http://dublincore.org/ --}}
	<meta name="DC.title" content="CMS">
	<meta name="DC.subject" content="@yield('description', 'default goes here')">
	<meta name="DC.creator" content="@yield('author', 'default goes here')">
	{{--  Mobile Viewport Fix --}}
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

	<title>CMS :: {{ isset($title) ? $title : 'Site' }}</title>
	{{-- Favicon; 16x16/32x32; transparency OK; http://mky.be/favicon/ --}}
	<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
	{{-- iOS favicons. --}}
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">

	{{-- CSS --}}
	<link rel="stylesheet" type="text/css" href="{{{ asset('assets/css/frontend.css') }}}" />

	<style>
	@yield('styles')
	</style>

	{{-- HTML5 shim, for IE6-8 support of HTML5 elements --}}
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<script type="text/javascript" src="{{{ asset('assets/js/googleanalytics.js') }}}" ></script>
</head>

<body>
	{{-- NAVBAR --}}
	<div class="navbar navbar-default navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				{{-- BRANDING --}}
				<a class="navbar-brand" href="/">CMS</a>
				{{-- COLLAPSED NAV BUTTON --}}
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			{{-- MAIN NAV: w/collapse-ability - "navbar-collapse" declared --}}
			<nav class="collapse navbar-collapse navbar-ex1-collapse">
				{{-- SITE NAV --}}
				<ul class="nav navbar-nav">
					<li {{ (Request::is('/') ? ' class="active"' : '') }}><a href="{{{ URL::to('') }}}">Home</a></li>
					<li {{ (Request::is('blog') ? ' class="active"' : '') }}><a href="{{{ URL::to('blog') }}}">Blog</a></li>
					<li {{ (Request::is('contact-us') ? ' class="active"' : '') }}><a href="{{{ URL::to('contact-us') }}}">Contact</a></li>
				</ul>
				{{-- USER NAV --}}
				<ul class="nav navbar-nav navbar-right">
					{{-- LOGGED IN --}}  
					@if (Auth::check())
					{{-- ADMIN-ONLY TOOLS --}} 
					@if (Auth::user()->hasRole('admin'))
					<li><a href="{{{ URL::to('admin') }}}">Admin CMS</a></li>
					@endif
					{{-- USER TOOLS --}}
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span class="glyphicon glyphicon-user"></span> Hello, {{{ Auth::user()->username }}} <span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="{{{ URL::to('user') }}}"><span class="glyphicon glyphicon-wrench"></span> Manage Account</a></li>
							<li class="divider"></li>
							<li><a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> Logout</a></li>
						</ul>
					</li>
					{{-- LOGGED OUT --}}   
					@else
					<li {{ (Request::is('user/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/login') }}}">Login</a></li>
					<li {{ (Request::is('user/register') ? ' class="active"' : '') }}><a href="{{{ URL::to('user/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
					@endif
				</ul>
			</nav> {{-- /nav-collapse --}}
		</div> {{-- /nav container --}}
	</div> <!-- /navbar -->

	{{-- CONTAINER --}}
	<div class="container">

		@include('notifications')	{{-- notifications --}}
		@yield('content')			{{-- content --}}

	</div> <!-- /container -->

	{{-- FOOTER --}}
	<div id="footer">
		<div class="container">
			<p class="muted credit">&copy; 2014 CMS</p>
		</div>
	</div>

	{{-- JS --}}
	<script type="text/javascript" src="{{{ asset('assets/js/frontend.js') }}}" ></script>

	<script type="text/javascript">

	$(document).ready(function(){

		@yield('onReady')

	});

	</script>

	@yield('scripts')

</body>
</html>
