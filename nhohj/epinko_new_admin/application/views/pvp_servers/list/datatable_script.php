
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
                    responsive: true,
                    searchDelay: 100,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?= base_url('pvp-server-list-table') ?>",
                        type: 'POST',
                        data: {
                            columnsDef: ['id', 'name', 'image', 'tarih','beta','link', 'tur', 'durum', 'security', 'action'],
                        },
                    },
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'image' },
                        { data: 'tarih' },
                        { data: 'beta' },
                        { data: 'link' },
                        { data: 'tur' },
                        { data: 'security' },
                        { data: 'durum' },
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
                                if (row.image) {
                                    return '<img src="../upload/category/' + row.image + '" height="75" width="75"/>';
                                } else {
                                    return "Resim Eklenmemiş";
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
                            orderable: true,
                            searchable: true,
                            visible: true,
                            targets: 5,
                            "render": function (data, type, row) {
                                return row.link.length == 0 ? "Link Yok":("<a href='"+row.link+"' target='_blank' class='btn btn-primary'>Link'e Git</a>");
                            }
                        },
                        {
                            orderable: true,
                            searchable: true,
                            visible: true,
                            targets: 6
                        },
                        {
                            orderable: true,
                            searchable: true,
                            visible: true,
                            targets: 7
                        },
                        {
                            orderable: true,
                            searchable: false,
                            targets: 8,
                            "render": function (data, type, row) {
                                return row.durum === "1" ?
                                    '<span class="switch switch-outline switch-icon switch-success">' +
                                    '<label><input type="checkbox" id="switch-lg_4_'+row.id+'" checked data-url="<?= base_url('pvp-server-veri-guncelle/durum/') ?>' + row.id + '" onchange="durum_degistir(4,'+ row.id +')" name="select"><span></span></label></span>' :
                                    '<span class="switch switch-outline switch-icon switch-success">' +
                                    '<label><input type="checkbox" id="switch-lg_4_'+row.id+'" data-url="<?= base_url('pvp-server-veri-guncelle/durum/') ?>' + row.id + '" onchange="durum_degistir(4,'+ row.id +')" name="select"><span></span></label></span>';
                            }
                        },
                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row) {
                                return '<a href="<?= base_url('pvp-server-guncelle/') ?>' + row.id + '" class="btn btn-sm btn-clean btn-icon" title="Güncelle">' +
                                        '<i class="la la-edit text-edit"></i></a>' +
                                        '<a class="btn btn-sm btn-clean btn-icon" onclick="sosyalDelete(' + row.id + ')" data-toggle="modal" data-id="' + row.id + '" data-target="#menu">' +
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