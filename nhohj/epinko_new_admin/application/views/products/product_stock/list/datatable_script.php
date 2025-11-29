<script>
    /******/ (() => {
        "use strict";
        var __webpack_exports__ = {};
        var KTDatatablesDataSourceAjaxServer = function() {

            var initTable1 = function() {
                var table = $('#kt_datatable');
                // begin first table
                var dataTable = table.DataTable({
                    responsive: true,
                    searchDelay: 500,
                    "language":{
                        "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                    },
                    order: [[ 1, "desc" ]], // Sıralama 0 yerine 1. sütuna göre yapılıyor (ID yerine)
                    "columnDefs": [
                        { "orderable": false, "targets": 0 } // Checkbox sütunu sıralanamaz
                    ],
                    "initComplete": function () {
                        // Apply the search
                        this.api().columns().every( function () {
                            var that = this;
                            var searchText=$(this.header()).find('input[type="search"]');
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

                // Tümünü Seç/Seçme
                $('#checkAll').on('click', function(){
                    var rows = dataTable.rows({ 'search': 'applied' }).nodes();
                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                });

                // Tek checkbox seçildiğinde "Tümünü Seç" checkbox'ını güncelle
                $('#kt_datatable tbody').on('change', 'input[type="checkbox"]', function(){
                    if(!this.checked){
                        var el = $('#checkAll').get(0);
                        if(el && el.checked && ('indeterminate' in el)){
                            el.indeterminate = true;
                        }
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
