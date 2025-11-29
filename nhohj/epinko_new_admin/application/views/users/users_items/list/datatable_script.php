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
                        url: "<?= base_url("uye-list-table") ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','full_name','email','ilan_balance','nick_name',"tc_onay","email_onay","tel_onay",'created_at','balance','status','action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },

                    columns: [
                        {data: 'ssid'  },
                        {data: 'email',responsivePriority: 2},
                        {data: 'nick_name',responsivePriority: 1},
                        {data: 'balance',responsivePriority: 3},
                        {data: 'ilan_balance',responsivePriority: 3},
                        {data: 'created_at',responsivePriority: 4},
                        {data: 'email_onay',responsivePriority: 4},
                        {data: 'tel_onay',responsivePriority: 4},
                        {data: 'tc_onay',responsivePriority: 4},
                        {data: 'status'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    order: [[ 0, "desc" ]],
                    columnDefs: [
                        {
                            orderable:true,
                            searchable:false,
                            visible:false,
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
                            searchable:true,
                            visible:true,
                            targets:3,
                            "render": function(data, type, row) {
                                return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(data);
                            }
                        },
                        {
                            orderable:true,
                            searchable:true,
                            visible:true,
                            targets:4,
                            "render": function(data, type, row) {
                                return new Intl.NumberFormat('tr-TR', { style: 'currency', currency: 'TRY' }).format(data);
                            }
                        },
                        {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:5,

                        },  {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:6,
                            "render": function (data, type, row) {
                                if(row.email_onay==0){
                                    return '<span><span class="label font-weight-bold label-lg  label-light-danger label-inline"> <i style="font-size:8pt;margin-right:5px; "  class="fa text-danger fa-envelope"></i> Onaylanmadı</span></span>';
                                }if(row.email_onay==2){
                                    return '<span><span class="label font-weight-bold label-lg  label-light-warning label-inline"> <i style="font-size:8pt;margin-right:5px; "  class="fa text-warning fa-envelope"></i> Onaylanmadı - Süresi Geçti</span></span>';
                                }else{
                                    return '<span><span class="label font-weight-bold label-lg  label-light-success label-inline"> <i style="font-size:8pt;margin-right:5px; "  class="fa text-success fa-envelope"></i> Onaylandı</span></span>';
                                }
                            }

                        },  {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:7,
                            "render": function (data, type, row) {
                                if(row.tel_onay==0){
                                    return '<span><span class="label font-weight-bold label-lg  label-light-danger label-inline"><i  style="font-size:8pt;margin-right:5px; " class="fa text-danger fa-phone"></i> Onaylanmadı</span></span>';
                                }else{
                                    return '<span><span class="label font-weight-bold label-lg  label-light-success label-inline"><i style="font-size:8pt;margin-right:5px; "  class="fa text-success fa-phone"></i> Onaylandı</span></span>';
                                }
                            }

                        },  {
                            orderable:true,
                            searchable:false,
                            visible:true,
                            targets:8,
                            "render": function (data, type, row) {
                                if(row.tc_onay==0){
                                    return '<span><span class="label font-weight-bold label-lg  label-light-danger label-inline"><i style="font-size:8pt;margin-right:5px; "  class="fa text-danger fa-user"></i> Onaylanmadı</span></span>';
                                }else{
                                    return '<span><span class="label font-weight-bold label-lg  label-light-success label-inline"><i style="font-size:8pt;margin-right:5px; "  class="fa text-success fa-user"></i> Onaylandı</span></span>';
                                }
                            }
                        },
                        /*{
                            orderable:true,
                            searchable:false,
                            targets:3,
                            "render": function (data, type, row) {
                                if(row.status==""){
                                    return '<span><span class="label font-weight-bold label-lg  label-light-danger label-inline">İlişkisiz</span></span>';
                                }else{
                                    return '<span><span class="label font-weight-bold label-lg  label-light-success label-inline">Türkpin</span></span>';
                                }
                            }
                        },*/
                        {
                            orderable:true,
                            searchable:false,
                            targets:9,
                            "render": function (data, type, row) {
                                if(row.status==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                                '<label><input type="checkbox" id="switch-lg_2_'+ row.ssid +'" checked data-url="<?= base_url('uye-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                                       'onchange="durum_degistir(2,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_2_'+ row.ssid +'"  data-url="<?= base_url('uye-veri-guncelle/status/') ?>' + row.ssid + '" ' +
                                        'onchange="durum_degistir(2,'+ row.ssid +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        /*{
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
                        },*/
                       /* {
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
                        },*/

                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                return '<a href="<?= base_url('uye-banka/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Banka Hesapları">'+
                                    '<i class="fas fa-money-check text-primary"></i></a>'+
                                    '<a href="<?= base_url('odeme-bildirimleri?u=') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Ödeme Bilgileri">'+
                                    '<i class="fa fa-wallet text-info"></i></a>'+
                                    '<a href="<?= base_url('siparisler?u=') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="ürün siparişleri">'+
                                    '<i class="fa fa-shopping-cart text-info"></i></a>'+
                                    '<a href="<?= base_url('ilan-siparisler?u=') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Siparişler">'+
                                    '<i class="la la-shopping-cart text-info"></i></a>'+
                                    '<a href="<?= base_url('uye-guncelle/') ?>'+ row.ssid +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+
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