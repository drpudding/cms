@extends('admin/layouts/modal')

{{-- Content --}}
@section('content')

{{-- Edit Blog Comment Form --}}
<form class="form-horizontal" method="post" autocomplete="off">

	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

	<!-- Activation Status -->
	<div class="form-group {{ $errors->has('status') ? 'error' : '' }}">	
		<div class="col-md-12">
			<label class="control-label" for="status">Status</label>
			<select class="form-control" name="status" id="status">
				<option value="1"{{{ ($comment->status == 1 ? ' selected="selected"' : '') }}}>active</option>
				<option value="0"{{{ ($comment->status == 0 ? ' selected="selected"' : '') }}}>inactive</option>
			</select>
			{{ $errors->first('status', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Content -->
	<div class="form-group {{{ $errors->has('content') ? 'error' : '' }}}">
		<div class="col-md-12">
			<label class="control-label" for="content"></label>
			<textarea class="form-control full-width wysihtml5" name="content" value="content" rows="10">{{{ Input::old('content', $comment->content) }}}</textarea>
			{{ $errors->first('content', '<span class="help-inline">:message</span>') }}
		</div>
	</div>
	<!-- ./ content -->

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