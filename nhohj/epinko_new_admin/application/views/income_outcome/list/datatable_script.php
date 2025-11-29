
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
                table.DataTable({
                    responsive: false,
                    searchDelay: 100,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?= base_url('gelir-gider-list-table') ?>",
                        type: 'POST',
                        data: {
                            columnsDef: ['id', 'description', 'type', 'amount', 'date', 'action'],
                        },
                    },
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'description' },
                        { data: 'type' },
                        { data: 'amount' },
                        { data: 'date' },
                        { data: 'action', responsivePriority: -1, searchable: false },
                    ],
                    order: [[0, "asc"]],
                    columnDefs: [
                        {
                            orderable: true,
                            searchable: false,
                            visible: true,
                            targets: 0,
                            type: "num"
                        },
                        {
                            orderable: true,
                            searchable: true,
                            visible: true,
                            targets: 1
                        },
                        {
                            orderable: false,
                            searchable: false,
                            targets: 2,
                            "render": function (data, type, row) {
                                if (row.type == 1) {
                                    return '<span class="badge badge-success">Gelir</span>';
                                } else {
                                    return '<span class="badge badge-danger">Gider</span>';
                                }
                            }
                        },
                        {
                            orderable: true,
                            searchable: true,
                            visible: true,
                            targets: 3
                        },
                        {
                            orderable: true,
                            searchable: true,
                            visible: true,
                            targets: 4
                        },
                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return '<a class="btn btn-sm btn-clean btn-icon" onclick="sosyalDelete(' + row.id + ')" data-toggle="modal" data-id="' + row.id + '" data-target="#menu">' +
                                        '<i class="la la-trash text-danger"></i></a>';
                            }
                        }
                    ],
                    "initComplete": function() {
                        this.api().columns().every(function () {
                            var that = this;
                            var searchText = $(this.header()).find('input');
                            searchText.on('keyup change clear', function () {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
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