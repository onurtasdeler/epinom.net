
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
                $('#kt_datatable thead th').each( function (i) {
                    var sayac=1;
                    var title = $(this).text();
                    if(title!="İşlemler" && title!="Durum" && title!="Kayıt Tarihi"){
                        $(this).html( '<input class="form-control" id="arama_input_' + i + '" type="text" placeholder=" '+ title+'" />' );
                    }
                });

                // begin first table
                table.DataTable({
                    sDom:'lrtip',
                    "lengthChange": false,
                    responsive: true,
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?= base_url("pages2-") ?>list-table/<?= $this->uri->segment(2) ?>",
                        type: 'POST',
                        data: {
                            // parameters for custom backend script demo
                            columnsDef: [
                                'ssid','adi', 'action'],
                        },
                    },
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/tr.json"
                    },
                    columns: [
                        {data: 'ssid'},
                        {data: 'adi'},
                        {data: 'action', responsivePriority: -1,searchable:false},
                    ],

                    columnDefs: [
                        {
                            orderable:false,
                            searchable:false,
                            visible:false,
                            targets:0
                        },
                        {
                            orderable:false,
                            searchable:true,
                            targets:1
                        },
                        {
                            targets: -1,
                            title: 'İşlemler',
                            orderable: false,
                            searchable:false,
                            render: function(data, type,row) {
                                return '\
							\<a href="<?= base_url('page-update/') ?>' + row.ssid + '" class="btn btn-sm btn-clean btn-icon" title="Düzenle">\
								<i class="la la-pencil"></i>\
							</a>\
							<a  class="btn btn-sm btn-clean btn-icon " onclick="categoryDelete(\'' + row.ssid + '\')"  data-toggle="modal" data-id="' + row.ssid + '"  data-target="#menu"><i  class="la la-trash text-danger"></i></a>';
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