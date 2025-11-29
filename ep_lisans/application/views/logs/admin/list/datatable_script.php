<?php
$w=0;

if($itemsSub){
    $w=$items->id;
}else{
    $w=0;
}

?>
<script>
    /******/ (() => { // webpackBootstrap
        /******/ 	"use strict";
        var __webpack_exports__ = {};
        /*!******************************************************************************!*\
          !*** ../demo1/src/js/pages/crud/datatables/data-sources/ajax-server-side.js ***!
          \******************************************************************************/

        var KTDatatablesDataSourceAjaxServer = function() {

            var initTable1 = function() {

                var table = $('#kt_datatable');


                // begin first table
                table.DataTable({

                    responsive: true,
                    searchDelay: 100,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?= base_url("alog-list-table") ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','mesaj','mesaj_title','status','date','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'ssid' },
                        {data: 'mesaj_title'},
                        {data: 'mesaj'},
                        {data: 'date'},
                        {data: 'status'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[ 3, "desc" ]],
                    columnDefs: [
                        {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:0,
                            type: "num"
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:1,
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:2,
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:3,
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:4,
                            "render": function (data, type, row) {
                                if(row.status==1){
                                    return '<span style="height:auto;" class="label label-inline label-light-warning text-primary font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas fa-user-cog text-primary "></i> İşlem Onay</span>';
                                }else if(row.status==2){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas  text-danger fa-window-close"></i> İşlem Red</span>';
                                }else if(row.status==3){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas fa-user-secret  text-danger"></i>Saldırı</span>';
                                }else if(row.status==5){
                                    return '<span style="height:auto;" class="label label-inline label-light-info font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas fa-cog text-success"></i>Otomatik İşlem</span>';
                                }else if(row.status==11){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas fa-cog text-success"></i>Silme İşlemi</span>';
                                }
                            }
                        },
                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                return '<a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(' + row.ssid + ')"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>';
                            },
                        },
                    ],
                    "initComplete": function () {
                        // Apply the search
                        this.api().columns().every( function () {
                            var that = this;
                            var searchText=$(this.header()).find('input');
                            searchText.on( 'keyup change clear', function () {
                                if ( that.search() !== this.value ) {
                                    that.search( this.value).draw();
                                }
                            });
                            searchText.on("click", function (e) {
                                e.stopPropagation();
                            });
                        });
                    }
                });
            };

            return {

                //main function to initiate the module
                init: function() {
                    initTable1();
                },

            };

        }();

        jQuery(document).ready(function() {
            KTDatatablesDataSourceAjaxServer.init();
            $("#kt_datatable_filter").hide();
        });

        /******/ })()
    ;
    //# sourceMappingURL=ajax-server-side.js.map
</script>