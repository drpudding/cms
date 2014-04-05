@extends('site.layouts.default')

{{-- Content --}}
@section('content')
@foreach ($posts as $post)

<div class="row">
	<div class="col-md-8">
		<!-- Post Title -->
		<div class="row">
			<div class="col-md-8">
				<h4><strong><a href="{{{ URL::to('blog/' . $post->viewUrl) }}}">{{ String::title($post->title) }}</a></strong></h4>
			</div>
		</div>
		<!-- Post Content -->
		<div class="row">
			<div class="col-md-2">
				<a href="{{{ URL::to('blog/' . $post->viewUrl) }}}" class="thumbnail"><img src="http://placehold.it/260x180" alt=""></a>
			</div>
			<div class="col-md-6">
				<p>
					{{ String::tidy(Str::limit($post->content, 200)) }}
				</p>
				<p><a class="btn btn-xs btn-default" href="{{{ URL::to('blog/' . $post->viewUrl) }}}">Read more</a></p>
			</div>
		</div>
		<!-- Post Footer -->
		<div class="row">
			<div class="col-md-8">
				<p></p>
				<p>
					<span class="glyphicon glyphicon-user"></span> by <span class="muted">{{{ $post->author->username }}}</span>
					| <span class="glyphicon glyphicon-calendar"></span> <!--Sept 16th, 2012-->{{{ $post->date() }}}
					| <span class="glyphicon glyphicon-comment"></span> 
					<a href="{{{ URL::to('blog/' . $post->viewUrl) }}}#comments">{{ $post->comments->count() }} {{ \Illuminate\Support\Pluralizer::plural('Comment', $post->comments->count()) }}</a>
				</p>
			</div>
		</div>
	</div>
</div>

<hr />
@endforeach

{{ $posts->links() }}

@stop
