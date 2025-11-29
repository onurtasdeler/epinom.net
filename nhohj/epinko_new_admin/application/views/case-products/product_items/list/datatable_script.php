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

                        url: "<?= base_url("case-list-table") ?>",

                        type: 'POST',

                        data: {

                            // parameters for custom backend script demo

                            columnsDef: [

                                'id','order_id','image','name','price','status','is_anasayfa','action'],

                        },

                    },

                    "language":{

                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"

                    },



                    columns: [

                        {data: 'order_id',  },

                        {data: 'image'},

                        {data: 'name'},

                        {data: 'price'},

                        {data: 'is_anasayfa'},

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

                                    return '<img src="../upload/product/' + row.image + '" height="75" width="75"/>';

                                }else{

                                    return "Resim Eklenmemiş";

                                }

                            }

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

                        },
                        
                        {
                            orderable:true,
                            searchable:false,
                            targets:4,
                            "render": function (data, type, row) {
                                if(row.is_anasayfa==1){
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                                '<label><input type="checkbox" id="switch-lg_2_'+ row.id +'" checked data-url="<?= base_url('kasa-veri-guncelle/is_anasayfa/') ?>' + row.id + '" ' +
                                                       'onchange="durum_degistir(2,'+ row.id +')" name="select"><span></span></label></span>';
                                }else{
                                    return '<span class="switch switch-outline switch-icon switch-success">' +
                                        '<label><input type="checkbox" id="switch-lg_2_'+ row.id +'"  data-url="<?= base_url('kasa-veri-guncelle/is_anasayfa/') ?>' + row.id + '" ' +
                                        'onchange="durum_degistir(2,'+ row.id +')" name="select"><span></span></label></span>';
                                }
                            }
                        },
                        {

                            orderable:true,

                            searchable:false,

                            targets:5,

                            "render": function (data, type, row) {

                                if(row.status==1){

                                    return '<span class="switch switch-outline switch-icon switch-success">' +

                                        '<label><input type="checkbox" id="switch-lg_4_'+ row.id +'" checked data-url="<?= base_url('kasa-veri-guncelle/status/') ?>' + row.id + '" ' +

                                        'onchange="durum_degistir(4,'+ row.id +')" name="select"><span></span></label></span>';

                                }else{

                                    return '<span class="switch switch-outline switch-icon switch-success">' +

                                        '<label><input type="checkbox" id="switch-lg_4_'+ row.id +'"  data-url="<?= base_url('kasa-veri-guncelle/status/') ?>' + row.id + '" ' +

                                        'onchange="durum_degistir(4,'+ row.id +')" name="select"><span></span></label></span>';

                                }

                            }

                        },



                        {

                            targets: -1,

                            title: 'İşlemler',

                            orderable: false,

                            searchable:false,

                            render: function(data, type,row) {

                                return ' <a href="<?= base_url('kasa-icerikleri/') ?>'+ row.id +'" class="btn btn-sm btn-clean btn-icon" title="Kasa İçeriği">' +

                                    '<i class="la la-star text-danger"></i></a>'+

                                    ' <a href="<?= base_url('kasa-urunleri?down=') ?>'+ row.id +'" class="btn btn-sm btn-clean btn-icon" title="Aşağı Taşı">' +

                                    '<i class="la la-arrow-down text-primary"></i></a>'+

                                    '<a href="<?= base_url('kasa-urunleri?up=') ?>'+ row.id +'" class="btn btn-sm btn-clean btn-icon" title="Yukarı Taşı">' +

                                        '<i class="la la-arrow-up text-primary"></i></a>'+

                                '<a href="<?= base_url('kasa-guncelle/') ?>'+ row.id +'" class="btn btn-sm btn-clean btn-icon" title="Güncelle">'+

                                    '<i class="la la-edit text-warning"></i></a>'+

                                '<a  class="btn btn-sm btn-clean btn-icon " onclick="caseDelete(' + row.id + ')"  data-toggle="modal" data-id="' + row.id + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>';

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