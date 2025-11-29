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
                        url: "<?= base_url("yorum-list-table") ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','full_name',"puan",'user_id',"order_id",'advert_id','is_yayin','comment','status','created_at','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'ssid' },
                        {data: 'full_name'},
                        {data: 'comment'},
                        {data: 'puan'},
                        {data: 'created_at'},
                        {data: 'status'},
                        {data: 'is_yayin'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[4, "desc" ]],
                    columnDefs: [
                        {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:0,
                            type: "num"
                        },
                        {
                            orderable:false,
                            searchable:false,
                            targets:1,
                            "render": function (data, type, row) {
                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.user_id +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.full_name + "</a></span>";
                            }
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:2,
                        },{
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:3,
                        },{
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:4,
                        },
                        {
                            orderable:false,
                            searchable:false,
                            targets:5,
                            "render": function (data, type, row) {
                                if(row.status==1){
                                    return '<span style="height:auto;" class="label label-inline label-light-warning font-weight-bold"> <i style="font-size:9pt; padding-right: 2px;" class="fas text-warning fa-clock"></i> Beklemede</span>';
                                }else if(row.status==2){
                                    return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"> <i style="font-size:9pt; padding-right: 2px;" class="fas text-success fa-check"></i> Onaylandı</span>';
                                }else{
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas text-danger fa-close"></i> Reddedildi</span>';
                                }
                            }
                        },
                        {
                            orderable:false,
                            searchable:false,
                            targets:6,
                            "render": function (data, type, row) {
                                if(row.is_yayin==0){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"> <i style="font-size:9pt; padding-right: 2px;" class="far text-danger fa-window-close"></i> Yayında Değil</span>';
                                }else if(row.is_yayin==1){
                                    return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"> <i style="font-size:9pt; padding-right: 2px;" class="fas text-success fa-check"></i> Yayında</span>';
                                }
                            }
                        },
                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                return '<a href="<?= base_url('yorum-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+
                                    '<i class="la la-search text-warning"></i></a>'+
                                '<a  class="btn btn-sm btn-clean btn-icon " onclick="sosyalDelete(' + row.ssid + ')"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>';
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