@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')

{{-- Create Role Form --}}
<form class="form-horizontal" method="post" autocomplete="off">

	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

	<!-- Name -->
	<div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
		<label class="col-md-1 control-label" for="name">Name</label>
		<div class="col-md-11">
			<input class="form-control" type="text" name="name" id="name" value="{{{ Input::old('name', isset($role) ? $role->name : null) }}}" />
			{{ $errors->first('name', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Permissions tab
	<div class="tab-pane" id="tab-permissions"> -->
	<div class="form-group permissions">
		<label class="col-md-1 control-label" for="name">Permissions</label>
		<div class="col-md-3">
			{{-- this was changed from BSS --}}
			@foreach ($permissions as $permission)
			<label>
				@if ($mode == 'create')
				<input type="checkbox" name="permissions[]" value="{{{ $permission->id }}}"{{{ ( in_array($permission->id, $selectedPermissions) ? ' checked="checked"' : '') }}}>{{{ $permission->display_name }}}
				@else
				<input type="checkbox" name="permissions[]" value="{{{ $permission->id }}}"{{{ ( ( in_array($permission->id, $selectedPermissions) OR (empty($selectedPermissions) && array_key_exists($permission->id, $currentPermissionIds)) ) ? ' checked="checked"' : '') }}}>{{{ $permission->display_name }}}
				@endif
			</label>
			@endforeach
		</div>
	</div>

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
