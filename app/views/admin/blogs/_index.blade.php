@extends('admin.layouts.default')

@section('keywords', 'Blogs administration')
@section('author', 'CMS')
@section('description', 'Blogs administration index')

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{ $title }}}
			<div class="pull-right">
				<a href="{{{ URL::to('admin/blogs/create') }}}" class="btn btn-small btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
			</div>
		</h3>
	</div>

	<table id="blogs" class="table table-striped table-hover">
		<thead>
			<tr>
				<td class="col-md-1"><input type="text" class="search_init" value="post id" name="post_id"></td>
				<td class="col-md-3"><input type="text" class="search_init" value="post title" name="post_title"></td>
				<td class="col-md-2"></td>
				<td class="col-md-2"></td>
				<td class="col-md-2"></td>
				<td class="col-md-2"></td>
			</tr>
			<tr>
				<th class="col-md-1">ID</th>
				<th class="col-md-3">{{{ Lang::get('admin/blogs/table.title') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/blogs/table.comments') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/blogs/table.status') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/blogs/table.created_at') }}}</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
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
				oTable = $('#blogs').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
                "bLengthChange": false,         // hide entries per pg menu
                "iDisplayLength": 10,           // default # of entries per page
                "aaSorting": [ [ 3, "asc" ], [ 1, "asc" ] ],    // default column sort
				"aoColumnDefs": [				// columns prefs (filter, sort)
			      { "bSearchable": true, "aTargets": [ 0,1,3] }, // id, title, status
			      { "bSearchable": false, "aTargets": [ 2,4,5 ] },
			      { "bSortable": true, "aTargets": [ 0,1,3 ] },
			      { "bSortable": false, "aTargets": [ 2,4,5 ] },
			    ],
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('admin/blogs/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		},
                "fnInitComplete": function(oSettings, json) {
                    // ColumnFilter: select
                    var filterIndexes = [3];
                    $("thead td").each( function ( i ) {
                        if ($.inArray(i, filterIndexes) !== -1) {
                            this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
                            $('select', this).change( function () {
                                // massaged values
                                var val = $.trim( $(this).val() );
                                switch( val )
                                    {
                                    case "archive":
                                      val = 2; break;
                                     case "active":
                                      val = 1; break;
                                    case "inactive":
                                      val = 0; break;
                                    }
                                oTable.fnFilter( val, i );
                            });
                        }
                    });
                }
			});
		});
	</script>
@stop