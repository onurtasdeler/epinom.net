<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php 
$taleps=getLangValue(97,"table_pages");
?>
<script>
    <?php $user=getActiveUsers(); ?>
    $("#fatima").change(function () {
        var ext = $(this).val().split('.').pop();
        if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {
            if (this.files[0].size > 2000000) {
                toastr.warning("<?= langS(58, 2) ?>")
                $("#rbtinput1").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
            } else {
                $("#profileImageLabel").html();
            }
        } else {
            toastr.warning("<?= langS(75, 2) ?>");
            $("#rbtinput1").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
        }
    });

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
            order: [[5, "asc"]],
            ajax: {
                url: "<?= base_url("get-support-list") ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'talepNo','talepKonu','tarih','gunTarih','talepDurum','action'],
                },
            },

            columns: [
                {data: 'talepNo',orderable: false, searchable: false,responsivePriority:-2},
                {data: 'talepNo',orderable: false, searchable: false,responsivePriority:-2},
                {data: 'talepKonu',searchable: false, responsivePriority:0},
                {data: 'tarih', responsivePriority: 0},
                {data: 'gunTarih', responsivePriority: 0},
                {data: 'talepDurum', responsivePriority: 0},
                {data: 'action', responsivePriority: 0, searchable: false, className: ""},
            ],
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    visible: false,
                    targets: 0,
                },
                {
                    orderable: false,
                    searchable: true,
                    visible: true,
                    targets: 1,
                    "render": function (data, type, row) {
                        return " # " + row.talepNo  ;
                    }
                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 2,
                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 3,
                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 4,
                },
                {
                    targets: 5,
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        if (row.talepDurum == 1) {
                            return '<span class="text-info"><?= langS(143,2)?></span>';
                        }else if(row.talepDurum == 2){
                            return '<span class="text-primary"><?= langS(144,2)?></span>';
                        }else if(row.talepDurum == 3){
                            return '<span class="text-success"><?= langS(145,2)?></span>';
                        }else if(row.talepDurum == 4){
                            return '<span class="text-success"><?= langS(145,2)?></span>';
                        }else{
                            return '<span class="text-warning"><?= langS(142,2)?></span>';
                        }
                    }
                },
                {
                    targets: -1,
                    title: 'İşlemler',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return '<a href="<?= base_url(gg().$taleps->link."/") ?>' + row.talepNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><i class="fa fa-edit text-info"></i></a>';
                     

                    }
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

        $("#supportForm").validate({
            rules: {

            },
            messages: {

            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("supportForm"));
                $("#submitButton").prop("disabled", true);
                $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
                $.ajax({
                    url: "<?= base_url("add-create-request") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                if (response.type == "validation") {
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    $("#submitButton").prop("disabled", false);
                                    $("#submitButton").html("<?= langS(137,2) ?>");
                                }else if(response.type="oturum"){
                                    window.location.reload();
                                } else {
                                    toastr.warning(response.message);
                                    $("#submitButton").prop("disabled", false);
                                    $("#submitButton").html("<?= langS(137,2) ?>");
                                }
                            } else {
                                $(".deleted").remove();
                                $("#uyCont .alert").removeClass("alert-danger").addClass("alert-success");
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(500);
                                $("#submitButton").remove();
                                toastr.success(response.message);
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            }
                        } else {
                            window.location.reload();
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        });


    });
</script>