<?php

$w = "";



?>





<script>

    /******/ (() => { // webpackBootstrap

        /******/ 	"use strict";

        var __webpack_exports__ = {};

        /*!******************************************************************************!*\

          !*** ../demo1/src/js/pages/crud/datatables/data-sources/ajax-server-side.js ***!

          \******************************************************************************/



        var KTDatatablesDataSourceAjaxServer = function () {



            var initTable1 = function () {



                var table = $('#kt_datatable');





                // begin first table

                table.DataTable({



                    responsive: true,

                    searchDelay: 100,

                    processing: true,

                    serverSide: true,

                    ajax: {

                        url: "<?= base_url("sell-to-us-order-list-table" . $w) ?>",

                        type: 'POST',

                        data: {

                            // parameters for custom backend script demo

                            columnsDef: [

                                'id', 'sipNo', 'userId', 'userName', 'productId', 'productName', 'total_price', 'type', 'status', 'createdAt', 'action'],

                        },

                    },

                    "language": {

                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"

                    },



                    columns: [

                        { data: 'sipNo' },

                        { data: 'userName' },

                        { data: 'productName' },

                        { data: 'unit_price' },

                        { data: 'quantity' },

                        { data: 'total_price' },

                        { data: 'createdAt' },

                        { data: 'type' },

                        { data: 'status' },

                        { data: 'action', responsivePriority: -1, searchable: false },

                    ],



                    order: [[6, "asc"]],

                    columnDefs: [

                        {

                            orderable: true,

                            searchable: true,

                            visible: true,

                            targets: 0,



                        }, {

                            orderable: true,

                            searchable: true,

                            visible: true,

                            targets: 1,

                            "render": function (data, type, row) {

                                return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a target="blank"  href="<?= base_url("uye-guncelle/") ?>' + row.userId + '" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.userName + "</a></span>";

                            }

                        }, {

                            orderable: true,

                            searchable: true,

                            visible: true,

                            targets: 2,

                            "render": function (data, type, row) {

                                return '<span style="height:auto;" class="label label-inline label-light-info font-weight-bold"><a target="blank" href="<?= base_url("bize-sat-urun-guncelle/") ?>' + row.productId + '" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + row.productName + "</a></span>";

                            }

                        }, {

                            orderable: true,

                            searchable: true,

                            visible: true,

                            targets: 3,

                            "render": function (data, type, row) {

                                return row.unit_price + " <?= getcur() ?>";

                            }

                        }, {

                            orderable: true,

                            searchable: true,

                            visible: true,

                            targets: 4,

                        }, {

                            orderable: true,

                            searchable: true,

                            visible: true,

                            targets: 5,

                            "render": function (data, type, row) {

                                return row.total_price + " <?= getcur() ?>";

                            }

                        },

                        {

                            orderable: true,

                            searchable: true,

                            visible: true,

                            targets: 6,

                        }, {

                            orderable: true,

                            searchable: true,

                            visible: true,

                            targets: 7,

                            "render": function (data, type, row) {

                                if (row.type == 0) {

                                    return '<span style="height:auto;" class="label label-inline label-light-warning font-weight-bold"><i class="fas fa-user" style="color:#FFA800"></i>&nbspBizden Al</span>';

                                } else if (row.type == 1) {

                                    return '<span style="height:auto;" class="label label-inline label-light-info font-weight-bold"><i class="fas fa-user" style="font-size:9pt; margin-right:2px;color:#FFA800"></i> &nbsp;Bize Sat</span>';

                                }
                            }

                        }, {

                            orderable: true,

                            searchable: true,

                            visible: true,

                            targets: 8,

                            "render": function (data, type, row) {

                                if (row.status == 0) {

                                    return '<span style="height:auto;" class="label label-inline label-light-warning font-weight-bold"><i class="fas fa-user" style="color:#FFA800"></i>&nbspBekliyor</span>';

                                } else if (row.status == 1) {

                                    return '<span style="height:auto;" class="label label-inline label-light-info font-weight-bold"><i class="fas fa-user" style="font-size:9pt; margin-right:2px;color:#FFA800"></i> &nbsp;İşleme Alındı</span>';

                                } else if (row.status == 2) {

                                    return '<span style="height:auto;" class="label label-inline label-light-warning font-weight-bold"><i class="fas fa-clock" style="font-size:9pt; margin-right:2px;"></i> &nbsp;Tamamlandı</span>';

                                } else if (row.status == 3) {
                                    return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i class="fas fa-check" style="font-size:9pt; margin-right:2px;"></i> &nbsp;İptal Edildi</span>';
                                }

                            }

                        },

                        {

                            targets: -1,

                            title: 'İşlemler',

                            orderable: false,

                            searchable: false,

                            render: function (data, type, row) {

                                return '<a href="<?= base_url('al-sat-siparis-guncelle/') ?>' + row.id + '" class="btn btn-sm btn-clean btn-icon" title="Güncelle">' +

                                    '<i class="la la-edit text-warning"></i></a>';

                            },

                        },

                    ],

                    "initComplete": function () {

                        // Apply the search

                        this.api().columns().every(function () {

                            var that = this;

                            var searchText = $(this.header()).find('input');

                            searchText.on('keyup change clear', function () {

                                if (that.search() !== this.value) {

                                    that.search(jQuery.fn.DataTable.ext.type.search.string(this.value)).draw();

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

                init: function () {

                    initTable1();

                },



            };



        }();



        jQuery(document).ready(function () {

            KTDatatablesDataSourceAjaxServer.init();

            $("#kt_datatable_filter").hide();

        });



        /******/
    })()

        ;

    //# sourceMappingURL=ajax-server-side.js.map

</script>