@extends('admin.layouts.default')

{{-- 
	Getting the Datatable for each list.
	Setting an initial sort but otherwise allowing sorting on all columns.
	Searchable columns are set on getData()
	??? Could move columns to getData(), too
 --}}

@section('content')

	<div class="page-header">
		<h3>
			{{{ $title }}}

			@if($section != 'comment')
					{{ Button::xs_info_link(URL::to('admin/' . $section  . 's/create'), 'New ' . $section, array('class' => 'iframe pull-right'))
					->with_icon('plus-sign')}}	
			@endif
		</h3>
	</div>

	{{-- FILTER FORMS
			This will check for any search filters passed

	 --}}
	@if( isset($filters) && !empty($filters) )

		@foreach($filters AS $filter)

		{{ Former::open('admin/' . $section . 's/')->method('GET') }}
			{{ Former::select($filter['fieldName'])
				->addOption('- all '. $filter['fieldName'] . 's -')
				->fromQuery($filter['data'], $filter['optionNameFld'], $filter['optionValueFld'])->addClass('filter') }}
		{{ Former::close() }}

		@endforeach

	@endif


	{{-- BEGIN CHECKBOX FORM --}}
	{{ Former::open('admin/' . $section . 's/bulk')->addClass('listForm') }}
	<div style="display:none">
		{{ Former::text('action') }}
		{{ Former::text('id') }}
	</div>


	{{-- Archive Menu --}}
	<?php

		$m = null;

		if($section != 'role') { // roles cannot be altered

			$m = '<div class="btn-group" id="archiveMenu">\
						<button type="button" class="btn-default btn btn-xs" disabled="">Activate</button>\
						<button data-toggle="dropdown" type="button" class="btn-default btn btn-xs dropdown-toggle" disabled=""> <span class="caret"></span></button>\
						<ul class="dropdown-menu">\
							<li><a data-action="activate" href="#">ACTIVATE ' . $section . '</a></li>\
							<li><a data-action="inactivate" href="#">INACTIVATE ' . $section . '</a></li>\\';

				switch($section) {

					case 'user': // users & comments cannot be archived
					case 'comment': break;
					default: $m .= '<li><a data-action="archive" href="#">ARCHIVE ' . $section . '</a></li>\\';
				}

			// ALL
			$m .= '
							<li><a data-action="soft delete" href="#">SOFT DELETE ' . $section . '</a></li>\
							<li><a data-action="delete" href="#">FULL DELETE ' . $section . '</a></li>\
						</ul>\
				</div>';
		}

		$m .= '<button type="button" class="btn-info btn btn-xs clearFilters">Clear Filters</button>';
	?>


	{{-- META DATA - generic but could be customized by section --}}
	@section('keywords', 'Users administration')
	@section('author', 'CMS')
	@section('description', 'Users administration index')

	{{-- DATATABLES --}}
   	{{Datatable::table()
   	->addColumn($columns) // set on getIndex
    //->addColumn('ID', 'Name', 'Permissions', 'Users', 'Actions')
    //->setOptions("aaSorting", [ [ 1, "desc" ] ]) 			// default column sort
    //->setOptions('aaSorting', array( array(1, 'asc'))) 	// default column sort ; alt syntax
    // ->setOptions('aoColumnDefs', array(					// custom sorting
    //             // array('bSortable' => true,  'aTargets' => [ 0,1,2,3,4,5,6 ] ),
    //             // array('bSortable' => false, 'aTargets' => [ 7] ),
    //             array('bSearchable' => true,  'aTargets' => [0,1,2,3,4,5,6] ),
    //             array('bSearchable' => false, 'aTargets' => [  7 ] )

    //             ))
	->setUrl(URL::to('admin/' . $section . 's/data')) // $data
    ->render('admin/datatable')}}

	{{ Former::close() }}

@stop

@section('scripts')

	<script type="text/javascript">

		/*___________ FILTER SUBMIT ___________*/
		$('.filter').change(function() {
        	this.form.submit();
    	});


		/*___________ CHECKBOX PROCESSING ___________*/

		// FOR SINGLE RECORD: set the hidden id form field; initiate submit
		function deleteEntity(id) {
			$('#id').val(id);
			submitForm('delete');
		}

		// FOR SINGLE RECORD: set the hidden id form field; initiate submit
		function archiveEntity(id) {
			$('#id').val(id);
			submitForm('archive');
		}

		// confirm deletes; set the hidden action form field; submit to action (postBulk)
		function submitForm(action) {

			if (action == 'delete') {
				if (!confirm('Are you sure you want to delete the selected record(s) and all related data?')) {
					return;
				}
			}

			if (action == 'soft') {
				if (!confirm('Are you sure you want to delete the selected record(s)?')) {
					return;
				}
			}	

			$('#action').val(action);
			$('form.listForm').submit();		
		}

		// enable/disable Archive Menu based on checkbox selection
		function setArchiveEnabled() {
			var checked = $('tbody :checkbox:checked').length > 0;
			$('#archiveMenu > button').prop('disabled', !checked);	
		}

		// WHEN DATATABLE IS READY
		// add Archive Menu and related click events in DOM
		window.onDatatableReady = function() {

			// append Archive Menu to table
			$('.dataTables_wrapper > .row > div:first').html('{{$m}}');

			// disable Archive Menu by default
			$('#archiveMenu > button').prop('disabled', true);

			$(':checkbox').prop('checked', false);

			// bind click: Select All checkboxes
			$('.selectAll').click(function() {
				$(this).closest('table').find(':checkbox').prop('checked', this.checked);
			});

			// bind click: checkbox enables/disables Archive menu
			$(':checkbox').click(function() {
				setArchiveEnabled();
			});

			// bind click: Archive Menu links
			$('#archiveMenu li a').click(function(e)
			{
				e.preventDefault();
				var element = $(this);
				var action = element.attr('data-action');
				submitForm(action);
			});

			// bind click: first button submit to Archive action
			$('#archiveMenu > button:first').click(function() {
				submitForm('activate');
			});
		}

	</script>

@stop

@section('onReady')

	{{-- DEAL WITH THE ARCHIVE MENU --}}

	{{-- append Archive Menu to layout
	$('.dataTables_wrapper > .row > div:first').append('{{$a}}'); --}}

	{{-- upon arrival, disable ALL Archive Menu buttons 
	$('#archiveMenu > button').prop('disabled', true); --}}

	{{-- bind click: Archive Menu links
	$('#archiveMenu li a').click(function(e)
	{
		e.preventDefault();
		var element = $(this);
		var action = element.attr('data-action');
		submitForm(action);
	}); --}}

	{{-- bind click: first button to archive
	$('#archiveMenu > button:first').click(function() {
		submitForm('archive');
	}); --}}

	{{-- when Datatable is ready, have checkbox clicks enable/disable the selection dropdown
	window.onDatatableReady = function() {
		$(':checkbox').click(function() {
			setArchiveEnabled();
		});
	} --}}

	{{-- bind click: if a checkbox is checked, enable dropdown; otherwise, disable
	function setArchiveEnabled() {
		var checked = $('tbody :checkbox:checked').length > 0;
		$('#archiveMenu > button').prop('disabled', !checked);	
	} --}}

	{{-- bind click: Select All checkboxes
	$('.selectAll').click(function() {
		$(this).closest('table').find(':checkbox').prop('checked', this.checked);
	}); --}}
	

	{{--
		// click anywhere on row will check checkbox
		$('tbody tr').click(function(event) {
			if (event.target.type !== 'checkbox' && event.target.type !== 'button' && event.target.tagName.toLowerCase() !== 'a') {
				$checkbox = $(this).closest('tr').find(':checkbox');
				var checked = $checkbox.prop('checked');
				$checkbox.prop('checked', !checked);
				setArchiveEnabled();
			}
		});

		// mouseover on row will show action pulldown
		$('tbody tr').mouseover(function() {
			$(this).closest('tr').find('.tr-action').css('visibility','visible');
		}).mouseout(function() {
			$dropdown = $(this).closest('tr').find('.tr-action');
			if (!$dropdown.hasClass('open')) {
				$dropdown.css('visibility','hidden');
			}			
		});
	--}}

	{{-- The Search Filter

	var tableFilter = '';
	var searchTimeout = false;

	var oTable0 = $('#DataTables_Table_0').dataTable();
	var oTable1 = $('#DataTables_Table_1').dataTable();	
	function filterTable(val) {	
		if (val == tableFilter) {
			return;
		}
		tableFilter = val;
		oTable0.fnFilter(val);
    	@if (isset($secEntityType))
    		oTable1.fnFilter(val);
		@endif
	}

	$('#tableFilter').on('keyup', function(){
		if (searchTimeout) {
			window.clearTimeout(searchTimeout);
		}

		searchTimeout = setTimeout(function() {
			filterTable($('#tableFilter').val());
		}, 1000);					
	}) 

	--}}
	
@stop