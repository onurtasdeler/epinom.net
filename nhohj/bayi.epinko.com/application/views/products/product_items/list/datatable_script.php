<?php
$w="";
if(isset($_GET["c"]) && $_GET["c"]!=""){
   $w="?c=".$_GET["c"];
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
                        url: "<?= base_url("prbayi-list-table".$w) ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','sorder','p_name','c_name','status','bayi_status','price_sell','price_sell_discount','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'sorder',  },
                        {data: 'p_name'},
                        {data: 'c_name'},
                        {data: 'price_sell'},
                        {data: 'status'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[ 0, "asc" ]],
                    columnDefs: [
                        {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:0,
                            type: "num"
                        },
                        /*{
                            orderable:false,
                            searchable:false,
                            targets:2,
                            "render": function (data, type, row) {
                                if(row.simage){
                                    return '<img src="../upload/product/' + row.simage + '" height="75" width="75"/>';
                                }else{
                                    return "Resim Eklenmemiş";
                                }
                            }
                        },*/
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:1,
                        }, {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:2,
                        },{
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:3,
                            "render": function (data, type, row) {
                                if(row.price_sell_discount==0){
                                    return row.price_sell + " <?= getcur() ?> ";

                                }else{
                                    return row.price_sell + "<?= getcur() ?> <br> İndirimli Fiyat: " + row.price_sell_discount + " <?= getcur() ?>"

                                }
                            }

                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:4,
                            "render": function (data, type, row) {
                                if(row.bayi_status==0){
                                    return '<span class="badge badge-warning">Satışta</span>';
                                }else if(row.bayi_status==1){
                                    if(row.status==1){
                                        return '<span class="badge badge-success">Satışta</span>';

                                    }else{
                                        return '<span class="badge badge-info">Onaylandı - Satışta Değil</span>';

                                    }
                                }else if(row.bayi_status==2) {
                                    return '<span class="badge badge-danger">Reddedildi </span>';
                                }
                            }
                        },

                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                return '<a href="<?= base_url('urun-stoklar/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Stoklar">' +
                                    '<i class="la la-list text-info"></i></a>'+

                                    '<a href="<?= base_url('urunler-kar/') ?>' + row.ssid + '" class="btn btn-sm btn-clean btn-icon" title="">'+
                                    '<i class="la la-sort-numeric-asc text-warning"></i></a>' +

                                '<a href="<?= base_url('urun-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+
                                    '<i class="la la-edit text-warning"></i></a>'+
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