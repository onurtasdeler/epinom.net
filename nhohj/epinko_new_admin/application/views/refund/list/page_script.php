<script src="assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<script>
(() => {
    "use strict";
    var KTDatatablesDataSourceAjaxServer = function() {
        var initTable1 = function() {
            var table = $('#kt_datatable');

            table.DataTable({
                responsive: true,
                searchDelay: 100,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?= base_url('refund-requests') ?>",
                    type: 'POST',
                    data: function(d) {
                        return $.extend({}, d, {});
                    }
                },
                language: {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                },
                columns: [
                    { data: 'id' },
                    { 
                        data: 'user_name',
                        orderable: true,
                        searchable: true,
                        render: function(data, type, row) {
                            return '<span style="height:auto;" class="label label-inline label-light-primary font-weight-bold"><a href="<?= base_url("uye-guncelle/") ?>' + row.user_id + '" /><i class="fa fa-user" style="color:#3699FF; font-size:10pt;"></i>&nbsp ' + data + "</a></span>";
                        }
                    },
                    { data: 'payment_method' },
                    { data: 'paid_amount' },
                    { data: 'refund_reason' },
                    { 
                        data: 'refund_status',
                        orderable: true,
                        searchable: false,
                        render: function (data, type, row) {
                            if(data === 'approved'){
                                return '<span style="height:auto;" class="label label-inline label-light-success text-success font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas text-success fa-check"></i> Onaylandı</span>';
                            }else if(data === 'process'){
                                return '<span style="height:auto;" class="label label-inline label-light-warning text-warning font-weight-bold" ><i style="font-size:9pt; padding-right: 2px;" class="fas text-warning fa-spinner fa-spin mr-2"></i> İşlemde</span>';
                            }else if(data === 'rejected'){
                                return '<span style="height:auto;" class="label label-inline label-light-danger font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas  text-danger fa-times"></i> Reddedildi</span>';
                            }else{
                                return '<span style="height:auto;" class="label label-inline label-light-info font-weight-bold"><i style="font-size:9pt; padding-right: 2px;" class="fas text-info fa-info"></i> Beklemede</span>';
                            }
                        }
                    },
                    { data: 'payment_date' },
                    { data: 'action' }
                ],
                order: [
                    [6, "desc"]
                ],
                initComplete: function() {
                    this.api().columns().every(function() {
                        var that = this;
                        var searchText = $(this.header()).find('input');
                        searchText.on('keyup change clear', function() {
                            if (that.search() !== this.value) {
                                that.search(this.value).draw();
                            }
                        });
                        searchText.on("click", function(e) {
                            e.stopPropagation();
                        });
                    });
                }
            });
        };

        return {
            init: function() {
                initTable1();
            },
        };
    }();

    jQuery(document).ready(function() {
        KTDatatablesDataSourceAjaxServer.init();
        $("#kt_datatable_filter").hide();
    });
})();
</script>
