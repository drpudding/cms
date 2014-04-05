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

	<title>CMS :: {{ isset($title) ? $title : 'Administration' }}</title>
	{{-- Favicon; 16x16/32x32; transparency OK; http://mky.be/favicon/ --}}
	<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
	{{-- iOS favicons. --}}
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
	<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">

	{{-- CSS --}}
	<link rel="stylesheet" type="text/css" href="{{{ asset('assets/css/backend.css') }}}" />
	<link rel="stylesheet" type="text/css" href="{{{ asset('assets/css/colorbox.css') }}}" />
	<link rel="stylesheet" type="text/css" href="{{{ asset('assets/css/jquery.dataTables.css') }}}" />
	<link rel="stylesheet" type="text/css" href="{{{ asset('assets/css/jquery.datatables.css') }}}" />

	<style>
		@yield('styles')
	</style>

	{{-- HTML5 shim, for IE6-8 support of HTML5 elements --}}
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	{{-- JS (datatables is happier with scripts at top) --}}
    <script type="text/javascript" src="{{{ asset('assets/js/backend.js') }}}" ></script>
	<script type="text/javascript" src="{{{ asset('assets/js/googleanalytics.js') }}}" ></script>

</head>

<body>

	{{-- NAVBAR --}}
	<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
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
				{{-- ADMIN SECTIONS NAV --}}
				<ul class="nav navbar-nav">
					{{-- dashboard --}}
					<li{{ (Request::is('admin') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin') }}}"><span class="glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
					{{-- blog --}}
					<li{{ (Request::is('admin/blogs*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/blogs') }}}"><span class="glyphicon glyphicon-list-alt"></span> Blog</a></li>
					{{-- comments --}}
					<li{{ (Request::is('admin/comments*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/comments') }}}"><span class="glyphicon glyphicon-bullhorn"></span> Comments</a></li>
					{{-- users tools dropdown --}}
					<li class="dropdown{{ (Request::is('admin/users*|admin/roles*') ? ' active' : '') }}">
						<a class="dropdown-toggle" data-toggle="dropdown" href="{{{ URL::to('admin/users') }}}">
							<span class="glyphicon glyphicon-user"></span> Users <span class="caret"></span>
						</a>
						{{-- tools --}}
						<ul class="dropdown-menu">
							<li{{ (Request::is('admin/users*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/users') }}}"><span class="glyphicon glyphicon-user"></span> Users</a></li>
							<li{{ (Request::is('admin/roles*') ? ' class="active"' : '') }}><a href="{{{ URL::to('admin/roles') }}}"><span class="glyphicon glyphicon-user"></span> Roles</a></li>
						</ul>
					</li>
				</ul>
				{{-- USER NAV --}}
				<ul class="nav navbar-nav navbar-right">
					<li><a href="{{{ URL::to('/') }}}"><span class="glyphicon glyphicon-home"></span> Site</a></li>
					<li class="divider-vertical"></li>
					{{-- login tools dropdown --}}
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<span class="glyphicon glyphicon-user"></span> {{{ Auth::user()->username }}} <span class="caret"></span>
						</a>
						{{-- tools --}}
						<ul class="dropdown-menu">
							<li><a href="{{{ URL::to('user') }}}"><span class="glyphicon glyphicon-wrench"></span> Manage Account</a></li>
							<li class="divider"></li>
							<li><a href="{{{ URL::to('user/logout') }}}"><span class="glyphicon glyphicon-share"></span> Logout</a></li>
						</ul>
					</li>
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

	<script type="text/javascript">
	
		$(document).ready(function(){

			@yield('onReady')

			// CLOSE MODAL (via colorbox overlay) and reload AJAX
			// $('#cboxOverlay').click(function(){
			// 	parent.$.colorbox.close();
			// 	return false;
			// });
			// 
		});

	</script>

	@yield('scripts')

</body>
</html>