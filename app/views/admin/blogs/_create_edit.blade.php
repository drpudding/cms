@extends('admin.layouts.modal')

@section('content')

<!-- Tabs -->
<ul class="nav nav-tabs">
	<li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
	<li><a href="#tab-meta-data" data-toggle="tab">Meta Data</a></li>
</ul>

{{-- Edit Blog Form --}}
<form class="form-horizontal" method="post" autocomplete="off">

	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

	<!-- Tabs Content -->
	<div class="tab-content">

		<!-- General tab -->
		<div class="tab-pane fade active in" id="tab-general">

			<!-- Activation Status -->
			<div class="form-group {{ $errors->has('status') ? 'error' : '' }}">	
				<div class="col-md-2">
					<label class="control-label" for="status">Status</label>
					@if ($mode == 'create')
					<select class="form-control" name="status" id="status">
						<option value="1"{{{ (Input::old('status', 0) == 1 ? ' selected="selected"' : '') }}}>active</option>
						<option value="2"{{{ (Input::old('status', 0) == 2 ? ' selected="selected"' : '') }}}>archive</option>
						<option value="0"{{{ (Input::old('status', 0) == 0 ? ' selected="selected"' : '') }}}>inactive</option>
					</select>
					@else
					<select class="form-control" name="status" id="status">
						<option value="1"{{{ ($post->status == 1 ? ' selected="selected"' : '') }}}>active</option>
						<option value="2"{{{ ($post->status == 2 ? ' selected="selected"' : '') }}}>archive</option>
						<option value="0"{{{ ($post->status == 0 ? ' selected="selected"' : '') }}}>inactive</option>
					</select>
					@endif
					{{ $errors->first('status', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Post Title -->
			<div class="form-group {{ $errors->has('title') ? 'error' : '' }}">
				<div class="col-md-12">
					<label class="control-label" for="title">Post Title</label>
					<input class="form-control" type="text" name="title" id="title" value="{{{ Input::old('title', isset($post) ? $post->title : null) }}}" />
					{{ $errors->first('title', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Content -->
			<div class="form-group {{ $errors->has('content') ? 'error' : '' }}">
				<div class="col-md-12">
					<label class="control-label" for="content">Content</label>
					<textarea class="form-control full-width wysihtml5" name="content" value="content" rows="10">{{{ Input::old('content', isset($post) ? $post->content : null) }}}</textarea>
					{{ $errors->first('content', '<span class="help-inline">:message</span>') }}
				</div>
			</div>
		</div><!-- ./ general data tab -->

		<!-- Meta Data tab -->
		<div class="tab-pane fade" id="tab-meta-data">
			<!-- Meta Title -->
			<div class="form-group {{ $errors->has('meta-title') ? 'error' : '' }}">
				<div class="col-md-12">
					<label class="control-label" for="meta-title">Meta Title</label>
					<input class="form-control" type="text" name="meta-title" id="meta-title" value="{{{ Input::old('meta-title', isset($post) ? $post->meta_title : null) }}}" />
					{{ $errors->first('meta-title', '<span class="help-inline">:message</span>') }}
				</div>
			</div>


			<!-- Meta Description -->
			<div class="form-group {{ $errors->has('meta-description') ? 'error' : '' }}">
				<div class="col-md-12 controls">
					<label class="control-label" for="meta-description">Meta Description</label>
					<input class="form-control" type="text" name="meta-description" id="meta-description" value="{{{ Input::old('meta-description', isset($post) ? $post->meta_description : null) }}}" />
					{{ $errors->first('meta-description', '<span class="help-inline">:message</span>') }}
				</div>
			</div>

			<!-- Meta Keywords -->
			<div class="form-group {{ $errors->has('meta-keywords') ? 'error' : '' }}">
				<div class="col-md-12">
					<label class="control-label" for="meta-keywords">Meta Keywords</label>
					<input class="form-control" type="text" name="meta-keywords" id="meta-keywords" value="{{{ Input::old('meta-keywords', isset($post) ? $post->meta_keywords : null) }}}" />
					{{{ $errors->first('meta-keywords', '<span class="help-inline">:message</span>') }}}
				</div>
			</div>

		</div><!-- ./ meta data tab -->

	</div><!-- ./ tabs content -->

	<!-- Form Actions -->
	<div class="form-group">
		<div class="col-md-offset-2 col-md-10">
			<button type="button" class="btn-cancel close_popup">Cancel</button>
			<button type="reset" class="btn btn-default">Reset</button>
			<button type="submit" class="btn btn-success">Save</button>
		</div>
	</div>

</form>
@stop
