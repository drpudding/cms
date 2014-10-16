{{-- 
    DataTable passes several variables that can be used in the templat:
    $columns: the columns added (either via or list action Datatable)
    $data: the table data, added via Datatable
    $options: the datatable options (setOptions(); will override any set here)
    $callbacks: the callback options (setOptions(); will override any set here)
    the "checkbox" column is created if a 'checkbox' named column is present in $columns

    Multi-column text filters not in place, but this suggests how:
    https://github.com/Chumper/Datatable/issues/52
 --}}

<table class="table table-striped table-responsive {{ $class = str_random(8) }}">
    <colgroup>
        @for ($i = 0; $i < count($columns); $i++)
        <col class="con{{ $i }}" />
        @endfor
    </colgroup>
    <thead>
    <tr>
        @foreach($columns as $i => $c)
        <th align="center" valign="middle" class="head{{ $i }}" 
            @if ($c == 'checkbox')
                style="width:20px"            
            @endif
        >
            @if ($c == 'checkbox' && $hasCheckboxes = true) {{-- setting hasCheckboxes to true --}}
                <input type="checkbox" class="selectAll"/>
            @else
                {{ $c }}
            @endif
        </th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
    <tr>
        @foreach($d as $dd)
        <td>{{ $dd }}</td>
        @endforeach
    </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            @foreach($columns as $i => $c)
            <th align="center" valign="middle" class="head{{ $i }}">
                <!-- <input type="text" name="{{$c}}" value="{{$c}}" class="search_init"> -->
            </th>
            @endforeach
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
    jQuery(document).ready(function(){

        // dynamic table
        var oTable = jQuery('.{{ $class }}').dataTable({
            // OPTIONS (can override)
            "aaSorting": [],                        // defaults to no initial sort order
            "bAutoWidth": false,                    // don't auto-calculate column widths
            "sPaginationType": "bs_normal",         // bootstrap theme pagination
            "bLengthChange": false,                 // hide "records per pg" menu
            "iDisplayLength": 10,                   // # records per page
            //"bStateSave": true,                     // save pagination, filtering, and sort state by table
            //"iCookieDuration": 60*60*2            // state cookie duration (in seconds); default is 2 hrs.
            "oLanguage": {                          // search label
                "sSearch": "Search:"
            },
            "sDom" : "<'row'<'col-md-6'><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>", // layout
            // don't allow sorting on the checkbox col (0), or the Actions col (last)
            @if (isset($hasCheckboxes) && $hasCheckboxes)
                "aoColumnDefs" : [ {
                    'bSortable' : false,
                    'aTargets' : [ 0, {{ count($columns) - 1 }} ]
                } ],
            @endif

            // custom setOptions
            @foreach ($options as $k => $o)
                {{ json_encode($k) }}: {{ json_encode($o) }},
            @endforeach

            // CALLBACKS
            @foreach ($callbacks as $k => $o)
                {{ json_encode($k) }}: {{ $o }},
            @endforeach
            "fnDrawCallback": function(oSettings) {
                if (window.onDatatableReady) {
                    window.onDatatableReady(); // sends this to list script
                }
                // COLORBOX
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
                    }
                });

                // Clear Filters
                $('.clearFilters').click(function() {
                    oTable.fnFilterClear();
                }); 
            },
            "fnInitComplete": function(oSettings, json) {
                // Column Filtering: select menu(s)
                var filterIndexes = [1]; // which column(s)
                $("tfoot th").each( function ( i ) {
                    if ($.inArray(i, filterIndexes) !== -1) { 
                        this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
                        $('select', this).change( function () {
                            // set the db value based on the selected menu value
                            var val = $.trim( $(this).val() );
                            switch( val )
                                {
                                case "active":
                                  val = 1; break;
                                case "inactive":
                                  val = 0; break;
                                }
                            oTable.fnFilter( val, i-1); // filter column (i) by selected value
                        });
                    }
                });

                // $("tfoot th").each( function ( i ) {
                //     this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
                //     $('select', this).change( function () {
                //         oTable.fnFilter( $(this).val(), i );
                //     } );
                // } );
            }
        });

        /* ADDS FILTER FIELDS TO FOOTER */
        // var asInitVals = new Array();

        // $("tfoot input").keyup( function () {
        //     /* Filter on the column (the index) of this element */
        //     oTable.fnFilter( this.value, $("tfoot input").index(this) );
        // } );

        // /*
        //  * Support functions to provide a little bit of 'user friendlyness' to the textboxes in
        //  * the footer
        //  */
        // $("tfoot input").each( function (i) {
        //     asInitVals[i] = this.value;
        // } );

        // $("tfoot input").focus( function () {
        //     if ( this.className == "search_init" )
        //     {
        //         this.className = "";
        //         this.value = "";
        //     }
        // } );

        // $("tfoot input").blur( function (i) {
        //     if ( this.value == "" )
        //     {
        //         this.className = "search_init";
        //         this.value = asInitVals[$("tfoot input").index(this)];
        //     }
        // } );

    });
</script>