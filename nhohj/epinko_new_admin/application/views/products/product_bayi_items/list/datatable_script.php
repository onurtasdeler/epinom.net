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
                        url: "<?= base_url("product-list-table".$w) ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','sorder','p_name','iliski','c_name','cekilis_urunu','status','is_slider_bottom','is_new','is_populer','is_anasayfa','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'sorder',  },
                        {data: 'p_name'},
                        {data: 'c_name'},
                        {data: 'iliski'},
                        {data: 'is_anasayfa'},
                        {data: 'is_slider_bottom'},
                        {data: 'is_new'},
                        {data: 'is_populer'},
                        {data: 'cekilis_urunu'},
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
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:3,
                            "render": function (data, type, row) {
                                if(row.iliski==""){
                                    return '<span><span class="label font-weight-bold label-lg  label-light-danger label-inline">İlişkisiz</span></span>';
                                }else{
                                    return '<span><span class="label font-weight-bold label-lg  label-light-success label-inline">Türkpin</span></span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:4,
                            "render": function (data, type, row) {
                                if(row.is_anasayfa==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                                '<label><input type="checkbox" id="switch-lg_2_'+ row.ssid +'" checked data-url="<?= base_url('urun-veri-guncelle/is_anasayfa/') ?>' + row.ssid + '" ' +
                                                       'onchange="durum_degistir(2,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_2_'+ row.ssid +'"  data-url="<?= base_url('urun-veri-guncelle/is_anasayfa/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(2,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:5,
                            "render": function (data, type, row) {
                                if(row.is_slider_bottom==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_1_'+ row.ssid +'" checked data-url="<?= base_url('urun-veri-guncelle/is_slider_bottom/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(1,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_1_'+ row.ssid +'"  data-url="<?= base_url('urun-veri-guncelle/is_slider_bottom/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(1,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:6,
                            "render": function (data, type, row) {
                                if(row.is_new==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_3_'+ row.ssid +'" checked data-url="<?= base_url('urun-veri-guncelle/is_new/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(3,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_3_'+ row.ssid +'"  data-url="<?= base_url('urun-veri-guncelle/is_new/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(3,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:7,
                            "render": function (data, type, row) {
                                if(row.is_populer==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_5_'+ row.ssid +'" checked data-url="<?= base_url('urun-veri-guncelle/is_populer/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(5,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_5_'+ row.ssid +'"  data-url="<?= base_url('urun-veri-guncelle/is_populer/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(5,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:8,
                            "render": function (data, type, row) {
                                if(row.cekilis_urunu==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_11_'+ row.ssid +'" checked data-url="<?= base_url('urun-veri-guncelle/cekilis_urunu/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(11,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_11_'+ row.ssid +'"  data-url="<?= base_url('urun-veri-guncelle/cekilis_urunu/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(11,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            targets:9,
                            "render": function (data, type, row) {
                                if(row.status==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_4_'+ row.ssid +'" checked data-url="<?= base_url('urun-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(4,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_4_'+ row.ssid +'"  data-url="<?= base_url('urun-veri-guncelle/status/') ?>' + row.ssid + '" ' +
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
                                return ' <a href="<?= base_url('urun-ozel-alanlar/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Özel Alanlar">' +
                                    '<i class="la la-star text-danger"></i></a>'+
                                    ' <a href="<?= base_url('urun-stoklar/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Stoklar">' +
                                    '<i class="la la-list text-info"></i></a>'+
                                    ' <a href="<?= base_url('urunler?down=') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Aşağı Taşı">' +
                                    '<i class="la la-arrow-down text-primary"></i></a>'+
                                    '<a href="<?= base_url('urunler-kar/') ?>' + row.ssid + '" class="btn btn-sm btn-clean btn-icon" title="">'+
                                    '<i class="la la-sort-numeric-asc text-warning"></i></a>' +
                                    '<a href="<?= base_url('urunler?up=') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Yukarı Taşı">' +
                                        '<i class="la la-arrow-up text-primary"></i></a>'+
                                '<a href="<?= base_url('urun-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+
                                    '<i class="la la-edit text-warning"></i></a>'+
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