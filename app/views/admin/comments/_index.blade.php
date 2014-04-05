@extends('admin.layouts.default')

{{-- Content --}}
@section('content')
	<div class="page-header">
		<h3>
			{{{ $title }}}
		</h3>
	</div>

	<table id="comments" class="table table-striped table-hover">
		<thead>
			<tr>
				<td class="col-md-1"><input type="text" class="search_init" value="comment id" name="comment_id"></td>
				<td class="col-md-3"></td>
				<td class="col-md-2"></td>
				<td class="col-md-1"></td>
				<td class="col-md-2"></td>
				<td class="col-md-1"></td>
				<td class="col-md-2"></td>
			</tr>
			<tr>
				<th class="col-md-1">ID</th>
				<th class="col-md-3">{{{ Lang::get('admin/comments/table.title') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/blogs/table.post_id') }}}</th>
				<th class="col-md-1">{{{ Lang::get('admin/users/table.username') }}}</th>
				<th class="col-md-2">{{{ Lang::get('admin/users/table.status') }}}</th>
				<th class="col-md-1">{{{ Lang::get('admin/comments/table.created_at') }}}</th>
				<th class="col-md-2">{{{ Lang::get('table.actions') }}}</th>
			</tr>
		</thead>
	</table>
@stop

{{-- Scripts --}}
@section('scripts')
	<script type="text/javascript">
		var oTable;
		$(document).ready(function() {
				oTable = $('#comments').dataTable( {
				"sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				},
                "bLengthChange": false,         // hide entries per pg menu
                "iDisplayLength": 10,           // default # of entries per page
                "aaSorting": [[ 4, "desc" ]],    // default column sort
				"aoColumnDefs": [				// columns prefs (filter, sort)
			      { "bSearchable": true, "aTargets": [ 0,1,2,4 ] }, // id, title
			      { "bSearchable": false, "aTargets": [ 3,5,6 ] },
			      { "bSortable": true, "aTargets": [ 0,4,5] },
			      { "bSortable": false, "aTargets": [ 1,2,3,6 ] },
			    ],
				"bProcessing": true,
		        "bServerSide": true,
		        "sAjaxSource": "{{ URL::to('admin/comments/data') }}",
		        "fnDrawCallback": function ( oSettings ) {
	           		$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
	     		},
                "fnInitComplete": function(oSettings, json) {
                    // ColumnFilter: select
                    var filterIndexes = [4];
                    $("thead td").each( function ( i ) {
                        if ($.inArray(i, filterIndexes) !== -1) {
                            this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
                            $('select', this).change( function () {
                                // massaged values
                                var val = $.trim( $(this).val() );
                                switch( val )
                                    {
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
			}); /* end DataTables */
		});
	</script>
@stop