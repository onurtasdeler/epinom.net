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

                        url: "<?= base_url("bagis-gecmisi-list-table") ?>",

                        type: 'POST',

                        data: {

                            // parameters for custom backend script demo

                            columnsDef: [

                                'streamerId','streamerUsernam','streamerUserId','streamerNickname',
                                'donatorId','donatorNickname','donatorUsername','donatorMessage',
                                'donationAmount','comissionAmount','netProfit','createdAt'],

                        },

                    },

                    "language":{

                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"

                    },



                    columns: [

                        {data: 'streamerUsername'},

                        {data: 'streamerNickname'},

                        {data: 'donatorNickname'},

                        {data: 'donatorUsername'},
                        {data: 'donatorMessage'},
                        {data: 'donationAmount'},
                        {data: 'comissionAmount'},
                        {data: 'netProfit'},

                        {data: 'createdAt'}
                    ],



                    order: [[ 8, "desc" ]],

                    columnDefs: [

                        {

                            orderable:true,

                            searchable:false,

                            visible:true,

                            targets:0,
                            "render": function(data,type,row) {
                                return '<a href="<?= base_url("yayinci-basvurulari-guncelle") ?>/' + row.streamerId + '"/>' + row.streamerUsername + '</a>';
                            }

                        },

                        
                        {

                            orderable:false,

                            searchable:false,

                            targets:1,

                            "render": function (data, type, row) {
                                return '<a href="<?= base_url("uye-guncelle") ?>/' + row.streamerUserId + '"/>'+ row.streamerNickname +'</a>';
                            }

                        },
                        {

                            orderable:false,

                            searchable:false,

                            targets:2,

                            "render": function (data, type, row) {
                                return '<a href="<?= base_url("uye-guncelle") ?>/' + row.donatorId + '"/>'+ row.donatorNickname +'</a>';
                            }

                        }, 

                        {

                            orderable:true,

                            searchable:false,

                            targets:3,

                        },
                        {

                            orderable:true,

                            searchable:false,

                            targets:4,

                        },
                        {

                            orderable:true,

                            searchable:false,

                            targets:5,

                        },
                        {

                            orderable:true,

                            searchable:false,

                            targets:6,

                        },
                        {

                            orderable:true,

                            searchable:false,

                            targets:7,

                        },
                        {

                            orderable:true,

                            searchable:false,

                            targets:8,

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