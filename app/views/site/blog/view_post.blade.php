@extends('site.layouts.default')

{{-- Update the Meta Title --}}
@section('meta_title')
	@parent
@stop

{{-- Update the Meta Description --}}
@section('meta_description')
	@parent
@stop

{{-- Update the Meta Keywords --}}
@section('meta_keywords')
	@parent
@stop

{{-- Content --}}
@section('content')

	<h3>{{ $post->title }}</h3>
	<p>{{ $post->content }}</p>

	<div>
		<span class="badge badge-info">Posted {{{ $post->date() }}}</span>
	</div>

	<a id="comments"></a>
	<hr />
	<h4>{{{ $post->comments->count() }}} Comments</h4>

	@if ($post->comments->count())
		@foreach ($post->comments as $comment)
			<div class="row">
				<div class="col-md-1">
					<img class="thumbnail" src="http://placehold.it/60x60" alt="">
				</div>
				<div class="col-md-11">
					<div class="row">
						<div class="col-md-11">
							<span class="muted">{{{ $comment->author->username }}}</span>
							&bull;{{{ $comment->created_at }}}
						</div>

						<div class="col-md-11">
							<hr />
						</div>

						<div class="col-md-11">
							{{{ $comment->content }}}
						</div>
					</div>
				</div>
			</div>
			<hr />
		@endforeach
	@else
		<hr />
	@endif

	<a id="commentsubmit"></a>
	<h4>Add a Comment</h4>

	@if (!Auth::check())
		{{ Session::put('loginRedirect', '/blog/'. $post->slug); }}
		You need to be logged in to add comments. <a href="{{{ URL::to('user/login') }}}">Log in now.</a>
	@elseif ( ! $canComment )
		You do not have permission to add comments.
	@else
		@if ($message = Session::get('error'))
			<div class="alert alert-danger alert-dismissable">
			    <button type="button" class="close" data-dismiss="alert">&times;</button>
			    <strong>Error. </strong>
			    @if(is_array($message))
			        <p>
			        @foreach ($message as $m)
			            {{ $m }}<br>
			        @endforeach
			        </p>
			    @else
			        {{ $message }}
			    @endif
			</div>
		@endif

	{{ Former::open(URL::to('blog/' . $post->slug)) }}
	{{ Former::textarea('content')->rows(4)->label('') }}
	{{ Former::actions( Button::sm_default_submit('Submit') )}}
	{{ Former::close() }}

	@endif
@stop
