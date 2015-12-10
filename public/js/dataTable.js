/**
 * Created by Daniel on 01/12/2015.
 */

/* # Data tables
 ================================================== */


//===== Default datatable =====//

oTable = $('.datatable table').dataTable({
    "bJQueryUI": false,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    "oLanguage": {
        "sSearch": "<span>Filter:</span> _INPUT_",
        "sLengthMenu": "<span>Show entries:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    }
});


//===== Table with selectable rows =====//

oTable = $('.datatable-selectable table').dataTable({
    "bJQueryUI": false,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"datatable-header"Tfl><"datatable-scroll"t><"datatable-footer"ip>',
    "oLanguage": {
        "sSearch": "<span>Filter:</span> _INPUT_",
        "sLengthMenu": "<span>Show:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    },
    "oTableTools": {
        "sRowSelect": "multi",
        "aButtons":
            [
                {
                    "sExtends": "collection",
                    "sButtonText": "Tools <span class='caret'></span>",
                    "sButtonClass": "btn btn-primary",
                    "aButtons":    [ "select_all", "select_none" ]
                }
            ]
    }
});


//===== Table with media elements =====//

oTable = $('.datatable-media table').dataTable({
    "bJQueryUI": false,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    "oLanguage": {
        "sSearch": "<span>Filter:</span> _INPUT_",
        "sLengthMenu": "<span>Show:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    },
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 0, 4 ] }
    ]
});


//===== Table with pager =====//

oTable = $('.datatable-pager table').dataTable({
    "bJQueryUI": false,
    "bAutoWidth": false,
    "sPaginationType": "two_button",
    "sDom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    "oLanguage": {
        "sSearch": "<span>Filter:</span> _INPUT_",
        "sLengthMenu": "<span>Show entries:</span> _MENU_",
        "oPaginate": { "sNext": "Next →", "sPrevious": "← Previous" }
    }
});


//===== Table with tools =====//

oTable = $('.datatable-tools table').dataTable({
    "bJQueryUI": false,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"datatable-header"Tfl><"datatable-scroll"t><"datatable-footer"ip>',
    "oLanguage": {
        "sSearch": "<span>Filter:</span> _INPUT_",
        "sLengthMenu": "<span>Show:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    },
    "oTableTools": {
        "sRowSelect": "single",
        "sSwfPath": "media/swf/copy_csv_xls_pdf.swf",
        "aButtons": [
            {
                "sExtends":    "copy",
                "sButtonText": "Copy",
                "sButtonClass": "btn"
            },
            {
                "sExtends":    "print",
                "sButtonText": "Print",
                "sButtonClass": "btn"
            },
            {
                "sExtends":    "collection",
                "sButtonText": "Save <span class='caret'></span>",
                "sButtonClass": "btn btn-primary",
                "aButtons":    [ "csv", "xls", "pdf" ]
            }
        ]
    }
});


//===== Table with custom sorting columns =====//

oTable = $('.datatable-custom-sort table').dataTable({
    "bJQueryUI": false,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    "oLanguage": {
        "sSearch": "<span>Filter:</span> _INPUT_",
        "sLengthMenu": "<span>Show:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    },
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 0, 1 ] }
    ]
});


//===== Table with invoices =====//

oTable = $('.datatable-invoices table').dataTable({
    "bJQueryUI": false,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    "oLanguage": {
        "sSearch": "<span>Filter:</span> _INPUT_",
        "sLengthMenu": "<span>Show:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    },
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 1, 6 ] }
    ],
    "aaSorting": [[0,'desc']]
});


//===== Table with tasks =====//

oTable = $('.datatable-tasks table').dataTable({
    "aaSorting": [],
    "bJQueryUI": false,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    "oLanguage": {
        "sSearch": "<span>Filter tasks:</span> _INPUT_",
        "sLengthMenu": "<span>Show tasks:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    },
    "aoColumnDefs": [
        { "bSortable": false, "aTargets": [ 5 ] }
    ]
});


//===== Datatable with tfoot column filters =====//

var asInitVals = new Array();
var oTable = $('.datatable-add-row table').dataTable({
    "bJQueryUI": false,
    "bAutoWidth": false,
    "sPaginationType": "full_numbers",
    "sDom": '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    "oLanguage": {
        "sSearch": "<span>Filter all:</span> _INPUT_",
        "sLengthMenu": "<span>Show entries:</span> _MENU_",
        "oPaginate": { "sFirst": "First", "sLast": "Last", "sNext": ">", "sPrevious": "<" }
    }
});

$(".dataTables_wrapper tfoot input").keyup( function () {
    oTable.fnFilter( this.value, $(".dataTables_wrapper tfoot input").index(this) );
});


//===== Adding placeholder to Datatable filter input field =====//

$('.dataTables_filter input[type=text]').attr('placeholder','Type to filter...');






