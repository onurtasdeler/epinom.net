<?php
$w="";

if($this->input->get("u")){
    $w="?u=".$this->input->get("u");
}else{
    $w="";
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
                        url: "<?= base_url("odeme-bildirim-list-table".$w) ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','email','uid','order_id','payment_method','balance_amount','payment_channel',"order_id",'paid_amount','amount','description','status','cdate','status','type','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'ssid' },
                        {data: 'email'},
                        {data: 'order_id'},
                        {data: 'payment_method'},
                        {data: 'balance_amount'},
                        {data: 'amount'},
                        {data: 'description'},
                        {data: 'status'},
                        {data: 'cdate'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[ 8, "desc" ]],
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
                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.uid + '" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.email + "</a></span>";
                            }
                        },{
                            orderable:false,
                            searchable:false,
                            targets:2,

                        },

                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:3,
                            "render": function (data, type, row) {
                                if(row.payment_method==2){
                                    return "Manuel Ödeme Bildirimi";
                                }else if(row.payment_method==6){
                                    return "Epinkopin";
                                }else{
                                    return row.payment_method + " - " +row.payment_channel;
                                }

                            }
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:4,
                            "render": function (data, type, row) {
                                return row.balance_amount + " TL";
                            }
                        },  {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:5,
                            "render": function (data, type, row) {
                                return row.paid_amount + " TL";
                            }
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:6,
                            "render": function (data, type, row) {
                                if(row.status==1){
                                    return '<span style="height:auto;" class="label label-inline label-light-success text-success font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas text-success fa-check"></i> Ödeme Başarılı</span>';
                                }else{
                                    return  row.description;
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:7,
                            "render": function (data, type, row) {
                                if(row.status==1){
                                    return '<span style="height:auto;" class="label label-inline label-light-success text-success font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas text-success fa-check"></i> Onaylandı</span>';
                                }else if(row.status==0){
                                    return '<span style="height:auto;" class="label label-inline label-light-warning text-warning font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas text-warning fa-spinner fa-spin mr-2"></i> İşlemde</span>';
                                }else if(row.status==2){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas  text-danger fa-times"></i> Reddedildi</span>';
                                }else if(row.status==3){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas  text-danger fa-reply-all"></i>İade Edildi</span>';
                                }else if(row.status==4){
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas  text-danger fa-times"></i>İşlem Geçersiz</span>';
                                }
                            }
                        },{
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:8,
                        },
                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {

                                    return '<a href="<?= base_url('odeme-bildirim-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Bildirim Güncelle">'+
                                        '<i class="la la-arrow-right text-info"></i></a>'+
                                        '';


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