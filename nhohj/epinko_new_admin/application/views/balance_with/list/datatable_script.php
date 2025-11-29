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
                        url: "<?= base_url("cekim-talep-list-table") ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','full_name','user_id',"tokenNo",'tutar','bank_iban',"update_at",'status','created_at','bank_name','bank_user','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'tokenNo' },
                        {data: 'full_name'},
                        {data: 'bank_name'},
                        {data: 'bank_iban'},
                        {data: 'bank_user'},
                        {data: 'tutar'},
                        {data: 'created_at'},
                        {data: 'status'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[6, "desc" ]],
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
                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.user_id +'" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.full_name + "</a></span>";
                            }
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
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:4,
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:5,
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:6,
                        },
                        {
                            orderable:false,
                            searchable:false,
                            targets:7,
                            "render": function (data, type, row) {
                                if(row.status==0){
                                    return '<span style="height:auto;" class="label label-inline label-light-warning font-weight-bold"> <i style="font-size:9pt; padding-right: 2px;" class="fas text-warning fa-clock"></i> Beklemede</span>';
                                }else if(row.status==1){
                                    return '<span style="height:auto;" class="label label-inline label-light-success font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas text-danger fa-close"></i> Onaylandı</span>';
                                }else if(row.status==2){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas text-danger fa-close"></i>İptal Edildi</span>';
                                }
                            }
                        },
                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                return '<a href="<?= base_url('cekim-talep-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+
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