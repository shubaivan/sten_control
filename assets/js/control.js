import $ from "jquery";
require('bootstrap');

// const $  = require( 'jquery' );
// global.$ = global.jQuery = $;

require('datatables.net-dt/css/jquery.dataTables.min.css');
require('datatables.net-fixedheader-dt/css/fixedHeader.dataTables.min.css');
require('datatables.net-responsive-dt/css/responsive.dataTables.min.css');

import * as net from 'datatables.net';
import * as fh from 'datatables.net-fixedheader';
import * as r from 'datatables.net-responsive';


$(document).ready(function () {
    console.log('control');
    // $('#example').DataTable();


    const app_rest_apicontrol_getdatatableparams = window.Routing.generate('app_rest_apicontrol_getdatatableparams');
    $.ajax({
        type: "GET",
        url: app_rest_apicontrol_getdatatableparams,
        error: (result) => {
            console.log(result.responseJSON.status);
        },
        success: (data) => {
            const app_rest_apicontrol_getavailablerenderparams = window.Routing
                .generate('app_rest_apicontrol_getavailablerenderparams');

            var common_defs = [];
            $.each( data.for_prepare_defs, function( key, value ) {

            });

            // Setup - add a text input to each footer cell
            var separate_filter_column_keys = [];
            $('#empTable tfoot th').each( function (k, v) {
                var title = $(this).text();
                if ($.inArray(title, data.separate_filter_column ) !== -1) {
                    separate_filter_column_keys.push(k);
                    $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
                }
            } );


            var table = $('#empTable').DataTable({
                initComplete: function () {
                    // Apply the search
                    this.api().columns(separate_filter_column_keys).every( function () {
                        var that = this;

                        $( 'input', this.footer() ).on( 'keyup change clear', function () {
                            if ( that.search() !== this.value ) {
                                that
                                    .search( this.value )
                                    .draw();
                            }
                        } );
                    } );
                },
                'responsive': true,
                'fixedHeader': true,
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url':app_rest_apicontrol_getavailablerenderparams,
                },
                columns: data.th_keys,
                "columnDefs": common_defs
            });
        }
    })
});