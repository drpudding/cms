@extends('admin.layouts.default')

@section('keywords', 'Roles administration')
@section('author', 'CMS')
@section('description', 'Roles administration index')

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			Role Management

			<div class="pull-right">
				<a href="{{{ URL::to('admin/roles/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<table id="roles" class="table table-striped table-hover">
		<thead>
			 <tr>
                <td class="col-md-1"><input type="text" class="search_init" value="role id" name="role_id"></td>
                <td class="col-md-4"><input type="text" class="search_init" value="role name" name="role_name"></td>
                <td class="col-md-3"></td>
                <td class="col-md-2"></td>
                <td class="col-md-3"></td>
            </tr>
			<tr>
				<th class="col-md-1">ID</th>
				<th class="col-md-4">{{{ Lang::get('admin/roles/table.name') }}}</th>
				<th class="col-md-3">{{{ Lang::get('admin/roles/table.perms') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/roles/table.users') }}}</th>
				<th class="col-md-3">{{{ Lang::get('table.actions') }}}</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
				oTable = $('#roles').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
                "bLengthChange": false,         // hide entries per pg menu
                "iDisplayLength": 10,           // default # of entries per page
                "aaSorting": [[ 1, "asc" ]],    // default column sort
				"aoColumnDefs": [				// columns prefs (filter, sort)
			      { "bSearchable": true, "aTargets": [ 0,1 ] }, // id, name
			      { "bSearchable": false, "aTargets": [ 2,3,4 ] },
			      { "bSortable": true, "aTargets": [ 0,1 ] },
			      { "bSortable": false, "aTargets": [ 2,3,4 ] },
			    ],
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('admin/roles/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		}
			});
		});
	</script>
@stop