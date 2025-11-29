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
                        url: "<?= base_url("cekilis-yetki-table") ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','nick_name','user_id','onay_date','stat','red_date','created_at','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'ssid' },
                        {data: 'nick_name'},
                        {data: 'created_at'},
                        {data: 'stat'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[2, "desc" ]],
                    columnDefs: [
                        {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:0
                        },
                        {
                            orderable:false,
                            searchable:false,
                            targets:1,
                            "render": function (data, type, row) {
                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.user_id +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.nick_name + "</a></span>";
                            }
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:2,
                        },
                        {
                            orderable:false,
                            searchable:false,
                            targets:3,
                            "render": function (data, type, row) {
                                if(row.stat==0){
                                    return '<span style="height:auto;" class="label label-inline label-light-warning font-weight-bold"> <i style="font-size:9pt; padding-right: 2px;" class="fas text-warning fa-clock"></i> Beklemede</span>';
                                }else if(row.stat==1){
                                    return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas text-success fa-check"></i> Yetki Verildi - (' + row.onay_date + ')</span>';
                                }else if(row.stat==2){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas text-danger fa-times"></i> Reddedildi - ( ' +row.red_date + ' )</span>';
                                }
                            }
                        },
                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                if(row.stat==0){
                                    return '<a  class="btn btn-sm btn-clean btn-icon " onclick="yetkiModal(' + row.ssid + ',2)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu3"><i  class="la la-times text-danger"></i></a><a  class="btn btn-sm btn-clean btn-icon " onclick="yetkiModal(' + row.ssid + ',1)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu2"><i  class="la la-check text-success"></i></a>' +
                                        '<a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(' + row.ssid + ')"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>';
                                }else if(row.stat==1){
                                    return '<a  class="btn btn-sm btn-clean btn-icon " onclick="yetkiModal(' + row.ssid + ',2)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu3"><i  class="la la-times text-danger"></i></a>' +
                                        '<a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(' + row.ssid + ')"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>';
                                }else{
                                    return '<a  class="btn btn-sm btn-clean btn-icon " onclick="yetkiModal(' + row.ssid + ',1)"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu2"><i  class="la la-check text-success"></i></a>' +
                                        '<a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(' + row.ssid + ')"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>';
                                }

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