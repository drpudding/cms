@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')

	{{ Former::open() }}
	
	@if(isset($user))
		{{ Former::populate($user) }}
	@endif

	{{ Former::text('username') }}
	{{ Former::text('email') }}
	{{ Former::password('password') }}
	{{ Former::password('password_confirmation') }}
	{{ Former::select('confirmed')->options(array(
	 0  => 'no',
	 1  => 'yes')); }}

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

	{{ Former::actions( 
		Button::sm_cancel('Cancel',  array('class' => 'close_popup') ), 
		Button::sm_default_reset('Reset'),
		Button::sm_success_submit('Save') ) }}

	{{ Former:: close() }}
@stop