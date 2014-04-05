@extends('admin.layouts.modal')

{{-- Content --}}
@section('content')
    <!-- Tabs -->
    {{-- <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">General</a></li>
        </ul> --}}
    <!-- ./ tabs -->
    
    <p>Are you sure you want to delete this record?</p>

    {{-- Delete Blog Form --}}
    <form class="form-horizontal" method="post" autocomplete="off">
        <!-- CSRF Token -->
        <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
        <input type="hidden" name="id" value="{{ $comment->id }}" />
        <!-- ./ csrf token -->

        <!-- Form Actions -->
        <div class="control-group">
            <div class="controls">
                <element class="btn-cancel close_popup">Cancel</element>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
        <!-- ./ form actions -->
    </form>
@stop