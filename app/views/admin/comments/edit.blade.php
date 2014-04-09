@extends('admin/layouts/modal')

{{-- Content --}}
@section('content')

	{{ Former::open() }}

	@if (isset($comment))
		{{ Former::populate($comment) }}
	@endif

	{{ Former::select('status')->options(array(
	     0  => 'inactive',
	     1  => 'active')); }}

	{{ Former::textarea('content')->addClass('wysihtml5')->rows(10) }}

	{{ Former::actions( 
		Button::sm_cancel('Cancel',  array('class' => 'close_popup') ), 
		Button::sm_default_reset('Reset'),
		Button::sm_success_submit('Save') )}}

	{{ Former:: close() }}
	
@stop