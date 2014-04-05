{{-- 
    DataTable passes several variables that can be used in the templat:
    $columns: the columns added (either via or list action Datatable)
    $data: the tanle data, added via Datatable
    $options: the datatable options (setOptions(); will override any set here)
    $callbacks: the callback options (setOptions(); will override any set here)
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
            @if ($c == 'checkbox' && $hasCheckboxes = true)
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
</table>
<script type="text/javascript">
    jQuery(document).ready(function(){
        // dynamic table
        jQuery('.{{ $class }}').dataTable({
            // OPTIONS (can override)
            "aaSorting": [],                        // disable sorting by default
            "bAutoWidth": false,                    // don't auto-calculate column widths
            "sPaginationType": "bs_normal",         // bootstrap theme pagination
            "bLengthChange": false,                 // hide "records per pg" menu
            "iDisplayLength": 10,                   // # records per page
            "bStateSave": true,                     // save pagination, filtering, and sort state
            "oLanguage": {                          // search label
                "sSearch": "Search:"
            },
            "sDom" : "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>", // layout

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
                    window.onDatatableReady();
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
                    },
                    onClosed: function(){
                        location.reload(true); // refresh list on close (x)
                    }
                }); 
            }
        });
    });
</script>