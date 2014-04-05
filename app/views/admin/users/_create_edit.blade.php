@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')

{{-- Create User AND Edit User Form --}}
{{--  @if (isset($user)) action="{{ URL::to('admin/users/' . $user->id . '/edit') }}" @endif  --}}
<form class="form-horizontal" role="form" method="post" autocomplete="off">

	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />

	<!-- Username -->
	<div class="form-group {{ $errors->has('username') ? 'error' : '' }}">
		<label class="col-md-2 control-label" for="username">Username</label>
		<div class="col-md-10">
			<input class="form-control" type="text" name="username" id="username" value="{{{ Input::old('username', isset($user) ? $user->username : null) }}}" />
			{{ $errors->first('username', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Email -->
	<div class="form-group {{ $errors->has('email') ? 'error' : '' }}">
		<label class="col-md-2 control-label" for="email">Email</label>
		<div class="col-md-10">
			<input class="form-control" type="text" name="email" id="email" value="{{{ Input::old('email', isset($user) ? $user->email : null) }}}" />
			{{ $errors->first('email', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Password -->
	<div class="form-group {{ $errors->has('password') ? 'error' : '' }}">
		<label class="col-md-2 control-label" for="password">Password</label>
		<div class="col-md-10">
			<input class="form-control" type="password" name="password" id="password" value="" />
			{{ $errors->first('password', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Password Confirm -->
	<div class="form-group {{ $errors->has('password_confirmation') ? 'error' : '' }}">
		<label class="col-md-2 control-label" for="password_confirmation">Password Confirm</label>
		<div class="col-md-10">
			<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="" />
			{{ $errors->first('password_confirmation', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Confirmation/Activation Status -->
	<div class="form-group {{ $errors->has('activated') || $errors->has('confirm') ? 'error' : '' }}">
		<label class="col-md-2 control-label" for="confirm">Activate User?</label>
		<div class="col-md-10">
			@if ($mode == 'create')
				<select class="form-control" name="confirm" id="confirm">
					<option value="1"{{{ (Input::old('confirm', 0) === 1 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
					<option value="0"{{{ (Input::old('confirm', 0) === 0 ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
				</select>
			@else
				<select class="form-control" {{{ ($user->id === Confide::user()->id ? ' disabled="disabled"' : '') }}} name="confirm" id="confirm">
					<option value="1"{{{ ($user->confirmed ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.yes') }}}</option>
					<option value="0"{{{ ( ! $user->confirmed ? ' selected="selected"' : '') }}}>{{{ Lang::get('general.no') }}}</option>
				</select>
			@endif
			{{ $errors->first('confirm', '<span class="help-inline">:message</span>') }}
		</div>
	</div>

	<!-- Roles -->
	<div class="form-group {{ $errors->has('roles') ? 'error' : '' }}">
		<label class="col-md-2 control-label" for="roles">Roles</label>
		<div class="col-md-10">
			{{-- this was changed from BSS --}}
			<select class="form-control" name="roles[]" id="roles[]" multiple>
				@foreach ($roles as $role)
					@if ($mode == 'create')
						<option value="{{{ $role->id }}}"{{{ ( in_array($role->id, $selectedRoles) ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
					@else
						<option value="{{{ $role->id }}}"{{{ ( ( in_array($role->id, $selectedRoles) OR (empty($selectedRoles) && array_key_exists($role->id, $currentRoleIds)) ) ? ' selected="selected"' : '') }}}>{{{ $role->name }}}</option>
					@endif
				@endforeach
			</select>
			<span class="help-block">
				Select one or more user roles. Each role grants specific permissions.
			</span>
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