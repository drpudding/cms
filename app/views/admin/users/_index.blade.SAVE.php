@extends('admin.layouts.default')

@section('keywords', 'Users administration')
@section('author', 'CMS')
@section('description', 'Users administration index')

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h3>
            {{{ $title }}}
            <div class="pull-right">
                <a href="{{{ URL::to('admin/users/create') }}}" class="btn btn-sm btn-info iframe"><span class="glyphicon glyphicon-plus-sign"></span> Create</a>
            </div>
        </h3>
    </div>

    <table id="users" class="table table-striped table-hover">
        <thead>
            <tr>
                {{-- set the text filter fields --}}
                <td class="col-md-1"><input type="text" class="search_init" value="user id" name="user_id"></td>
                <td class="col-md-1"><input type="text" class="search_init" value="user name" name="user_name"></td>
                <td class="col-md-2"></td>
                <td class="col-md-2"></td>
                <td class="col-md-2"></td>
                <td class="col-md-2"></td>
                <td class="col-md-2"></td>
            </tr>
            <tr>
                <th class="col-md-1">ID</th>
                <th class="col-md-1">{{{ Lang::get('admin/users/table.username') }}}</th>
                <th class="col-md-2">{{{ Lang::get('admin/users/table.email') }}}</th>
                <th class="col-md-2">{{{ Lang::get('admin/users/table.roles') }}}</th>
                <th class="col-md-2">{{{ Lang::get('admin/users/table.confirmed') }}}</th>
                <th class="col-md-2">{{{ Lang::get('admin/users/table.created_at') }}}</th>
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

        // DATATABLES: used to return the list view data via AJAX using getData controller
        // also uses datatables.fnReloadAjax.js
        var oTable;
        $(document).ready(function() {

                //parent.$.colorbox.close();
                //parent.oTable.fnReloadAjax();

                oTable = $('#users').dataTable( {

                // "sDom": tell DataTables where to inject returned pieces
                // in <div class='row'>, nest <div class='col-md-6'>, then nest length/# of entries menu div (l), then close col div
                // create sib <div class='col-md-6'>, nest find (f), then close div, then add processing div (r), then close row div
                // add datatable div (t)
                // then start a new row, nest <div class='col-md-6'>, then nest info div (i), then close div
                // in <div class='col-md-6'>, nest pagination (p), then close row
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    // _MENU_ is replace with a default menu, which can be changed
                    // http://datatables.net/usage/i18n
                    "sLengthMenu": "_MENU_ records per page"
                },
                "bLengthChange": false,         // hide the "entries per pg" menu
                "iDisplayLength": 10,           // default # of entries per page
                "aaSorting": [ [ 5, "desc" ] ], // default column sort and direction
                "aoColumnDefs": [               // columns prefs (searchable & sortable)
                  { "bSearchable": true, "aTargets": [ 0,1,4 ] }, // id, name, confirmed
                  { "bSearchable": false, "aTargets": [ 2,3,5,6 ] },
                  { "bSortable": true, "aTargets": [ 0,1,4,5 ] },
                  { "bSortable": false, "aTargets": [ 2,3,6 ] },
                ],
                "bProcessing": true,    // show "Processing..."
                "bServerSide": true,    // Process DataTable server side, using Ajax source
                "sAjaxSource": "{{ URL::to('admin/users/data') }}", // get URL for AdminUsersController
                /*
                Colorbox modal is bound to class='iframe', which is used on datatable Edit & Delete buttons.
                Clicking on the buttons opens the content in an iframe, with these settings.
                The content @extends('admin.layouts.modal'), where some custom js can be found.
                Also, see colorbox_custom.less for custom modal-content & modalLayout colorbox styles.
                */
                "fnDrawCallback": function ( oSettings ) {
                    $(".iframe").colorbox({
                        width:"40%", height:"70%",
                        transition: "fade", speed: 100,
                        iframe: true, 
                        opacity: 0.6,
                        overlayClose: false, // no close using overlay (see, layout/default.blade.php)
                        className: "modal-content", // twb modal class; also for custom styles
                        onOpen: function(){ // allows fade on without ghost div
                             $("#colorbox").css("opacity", 0);
                             $('#cboxOverlay').css({
                                'background-color': '#000', 
                                'visibility': 'visible'
                            });
                        },
                        onComplete: function(){
                            $("#colorbox").animate("opacity", 1);
                        },
                        onClosed: function(){
                            location.reload(true); // refresh list on close (x)
                        }
                    }); 
                },
                "fnInitComplete": function(oSettings, json) {
                    // Column Filtering: select menu(s)
                    // see thead for text filters
                    var filterIndexes = [4]; // which column(s)
                    $("thead td").each( function ( i ) {
                        if ($.inArray(i, filterIndexes) !== -1) {
                            this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
                            $('select', this).change( function () {
                                // set the db value based on the selected menu value
                                var val = $.trim( $(this).val() );
                                switch( val )
                                    {
                                    case "yes":
                                      val = 1; break;
                                    case "no":
                                      val = 0; break;
                                    }
                                oTable.fnFilter( val, i ); // filter column (i) by selected value
                            });
                        }
                    });
                }
            }); /* end DataTables */
        });

    </script>
@stop

