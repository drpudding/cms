@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')

	{{ Former:: open()  }}
	
	@if(isset($role))
		{{ Former::populate($role) }}
	@endif

	{{ Former::text('name') }}

	{{-- Former::checkboxes('permissions')->fromQuery($permissions, 'display_name', 'id') --}}

	<div class="form-group permissions">
		<label class="col-lg-2 col-sm-4 control-label" for="name">Permissions</label>
		<div class="col-lg-10 col-sm-8">

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

	{{ Former::actions( 
		Button::sm_cancel('Cancel',  array('class' => 'close_popup') ), 
		Button::sm_default_reset('Reset'),
		Button::sm_success_submit('Save') ) }}

	{{ Former:: close() }}

@stop