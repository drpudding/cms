@extends('admin.layouts.modal')

@section('content')

	<!-- Tabs -->
	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
		<li><a href="#tab-meta-data" data-toggle="tab">Meta Data</a></li>
	</ul>

	{{ Former::open() }}

	@if (isset($post))
		{{ Former::populate($post->getObject()) }}
	@endif

	<!-- Tabs Content -->
	<div class="tab-content">

		<!-- General tab -->
		<div class="tab-pane fade active in" id="tab-general">

			{{ Former::select('status')->options(array(
			     0  => 'inactive',
			     1  => 'active',
			     2  => 'archive')); }}

			{{ Former::text('title') }}
			{{ Former::textarea('content')->addClass('wysihtml5')->rows(10) }}

		</div>
		
		<!-- Meta Data tab -->
		<div class="tab-pane fade" id="tab-meta-data">

			{{ Former::text('meta_title') }}
			{{ Former::text('meta_description') }}
			{{ Former::text('meta_keywords') }}

		</div>

	</div>
	
	{{ Former::actions( 
		Button::sm_cancel('Cancel',  array('class' => 'close_popup') ), 
		Button::sm_default_reset('Reset'),
		Button::sm_success_submit('Save') )}}

	{{ Former:: close() }}
@stop
