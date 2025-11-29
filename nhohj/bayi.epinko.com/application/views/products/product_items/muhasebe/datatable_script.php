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

                    responsive: false,
                    searchDelay: 100,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?= base_url("category-list-table") ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','order_id','c_name','image','status','is_new','is_populer','is_anasayfa','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'order_id',  },
                        {data: 'image',  },
                        {data: 'c_name'},
                        {data: 'is_anasayfa'},
                        {data: 'is_new'},
                        {data: 'is_populer'},
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
                        {
                            orderable:false,
                            searchable:false,
                            targets:1,
                            "render": function (data, type, row) {
                                if(row.image){
                                    return '<img src="../upload/category/' + row.image + '" height="75" width="75"/>';
                                }else{
                                    return "Resim Eklenmemiş";
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:2,
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:3,
                            "render": function (data, type, row) {
                                if(row.is_anasayfa==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_2_'+ row.ssid +'" checked data-url="<?= base_url('kategori-veri-guncelle/is_anasayfa/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(2,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_2_'+ row.ssid +'"  data-url="<?= base_url('kategori-veri-guncelle/is_anasayfa/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(2,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:4,
                            "render": function (data, type, row) {
                                if(row.is_new==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_3_'+ row.ssid +'" checked data-url="<?= base_url('kategori-veri-guncelle/is_new/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(3,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_3_'+ row.ssid +'"  data-url="<?= base_url('kategori-veri-guncelle/is_new/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(3,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:5,
                            "render": function (data, type, row) {
                                if(row.is_populer==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_5_'+ row.ssid +'" checked data-url="<?= base_url('kategori-veri-guncelle/is_populer/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(5,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_5_'+ row.ssid +'"  data-url="<?= base_url('kategori-veri-guncelle/is_populer/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(5,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:6,
                            "render": function (data, type, row) {
                                if(row.status==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_4_'+ row.ssid +'" checked data-url="<?= base_url('kategori-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(4,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_4_'+ row.ssid +'"  data-url="<?= base_url('kategori-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(4,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },

                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                return '<a href="<?= base_url('kategoriler?down=') ?>' + row.ssid + '" class="btn btn-sm btn-clean btn-icon" title="Aşağı Taşı">'+
                                    '<i class="la la-arrow-down text-primary"></i></a>' +

                                '<a href="<?= base_url('kategoriler?up=') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Yukarı Taşı">' +
                                    '<i class="la la-arrow-up text-primary"></i></a>' +
                                    '<a href="<?= base_url('urunler?c=') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Ürünler">' +
                                    '<i class="la la-list text-info"></i></a>' +

                                ' <a href="<?= base_url('kategori-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">' +
                                    '<i class="la la-edit text-edit"></i></a>'+
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