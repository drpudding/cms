@extends('admin.layouts.modal')

@section('content')
    
    <p>Are you sure you want to fully delete this record, and <strong>ALL</strong> data related to this record?<br>
    	This action cannot be reversed.</p>
    <p>To delete this record, with an option to later undelete, select the Soft delete option in the bulk action menu.</p>

    {{ Former::open() }}
    {{-- $section is passed via getDelete, creating the target model e.g. $user->id --}}
    {{ Former::hidden('id')->value( $$section->id ) }}
    {{ Former::actions( Button::sm_default('Cancel',  array('class' => 'close_popup')), Button::sm_danger_submit('Delete') ) }}
    {{ Former::close() }}
    
@stop