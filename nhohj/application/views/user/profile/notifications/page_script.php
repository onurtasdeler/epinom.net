<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
$taleps=getLangValue(97,"table_pages");
?>
<script>
    <?php $user=getActiveUsers(); ?>


    $(document).ready(function (){
        var table = $('#kt_datatable');
        table.DataTable({
            responsive: true,
            searchDelay: 500,
            "language":{
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },
            dom:'rtip',
            serverSide: true,
            order: [[2, "desc"]],

            ajax: {
                url: "<?= base_url("get-list-my-notificate") ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: ['title','desc','tarih','action'],
                },
            },

            columns: [
                {data: 'title',orderable: false, searchable: false,responsivePriority:-1111},
                {data: 'desc',orderable: false,searchable: false,orderable: false,responsivePriority: -1},
                {data: 'tarih', orderable: false,responsivePriority: -1111},
            ],
            columnDefs: [

                {
                    orderable: false,
                    searchable: false,
                    visible: true,
                    targets: 0,
                },
                {
                    orderable: false,
                    searchable: false,
                    visible: true,
                    targets: 1,
                    render: function (data, type, row) {
                        return "<div class='text-wrap width-200'>" + row.desc + "</div>";
                    }
                },
                {
                    orderable: false,
                    searchable: false,
                    visible: true,
                    targets: 2,
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



    });
</script>