@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
    
    <p>Are you sure you want to delete this record?</p>

    {{-- Delete Role Form --}}
    <form class="form-horizontal" method="post" autocomplete="off">

        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <input type="hidden" name="id" value="{{ $role->id }}" />

        <!-- Form Actions -->
        <div class="control-group">
            <div class="controls">
                <button type="button" class="btn-cancel close_popup">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
    </form>
@stop
