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
	<link rel="stylesheet" type="text/css" href="{{{ asset('assets/css/wysihtml5/prettify.css') }}}" />
	<link rel="stylesheet" type="text/css" href="{{{ asset('assets/css/wysihtml5/bootstrap-wysihtml5.css') }}}" />

	<style>
		@yield('styles')
	</style>

	{{-- HTML5 shim, for IE6-8 support of HTML5 elements --}}
	<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	{{-- JS --}}
	<script type="text/javascript" src="{{{ asset('assets/js/backend.js') }}}" ></script>
	<script type="text/javascript" src="{{{ asset('assets/js/googleanalytics.js') }}}" ></script>

</head>

<body>

	{{-- CONTAINER --}}
	<div class="container modalLayout">

		@include('notifications')	{{-- notifications --}}

		<div class="page-header">	{{-- back --}}
			<h4>
				{{ $title }}
				<div class="pull-right">
					<button class="btn btn-default close_popup"><span class="glyphicon glyphicon-circle-arrow-left"></span> Back</button>
				</div>
			</h4>
		</div>

		{{-- CONTENT --}}
		@yield('content')

		{{-- FOOTER --}}
		<footer class="clearfix">
			@yield('footer')
		</footer>

	</div> <!-- /container -->

	<script type="text/javascript">
	
		$(document).ready(function(){

			// CLOSE MODAL (back, cancel) will close colorbox and reload the datatable AJAX
			$('.close_popup').click(function(){
				//location.reload(true);
				//parent.fnReloadAjax();
				parent.$.colorbox.close();
				return false;
			});

			// Adjusts colorbox modal to content ht & w
			parent.$.colorbox.resize({
	        	//innerWidth:$('body').width(),
	        	innerHeight:$('body').height() + 40
	    	});

		});

		$('.wysihtml5').wysihtml5();
		$(prettyPrint);

	</script>

	@yield('scripts')

</body>
</html>