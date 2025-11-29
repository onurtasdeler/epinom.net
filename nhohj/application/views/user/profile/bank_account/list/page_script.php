<script src="<?= base_url("assets/js/") ?>select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
$taleps=getLangValue(97,"table_pages");
?>
<script>
    <?php $user=getActiveUsers(); ?>

    function editModal(tip){
        if(tip){
            $.ajax({
                url: "<?= base_url("get-record-bank") ?>",
                type: 'POST',
                data: {data:tip},
                success: function (response) {
                    if (response) {
                        if (response.hata == "var") {
                           toastr.warning(response.message);
                        } else {
                            $("#editModal #m_banka_adi").val(response.name);
                            $('#editModal #m_mainCategory').val(response.type); // Select the option with a value of '1'
                            $('#editModal #m_mainCategory').trigger('change'); // Notify any JS components that the value changed
                            $("#editModal #m_iban").val(response.iban);
                            $("#editModal #m_bank_account").val(response.hesap);
                            $("#editModal #m_banka_adi").val(response.name);
                            $("#editModal #sToken").val(tip);
                            $("#editModal").modal("show");
                        }
                    } else {
                        //window.location.reload();
                    }
                },
                cache: false,
               
            });
        }
    }
    function deleteModal(tip){
        if(tip){
            $.ajax({
                url: "<?= base_url("set-delete-bank?t=1") ?>",
                type: 'POST',
                data: {data:tip},
                success: function (response) {
                    if (response) {
                        if (response.hata == "var") {
                           toastr.warning(response.message);
                        } else {
                            $("#deleteModal #ssToken").val(tip);
                            $("#deleteModal #bankDelete").html(response.message);
                            $("#deleteModal").modal("show");
                        }
                    } else {
                        //window.location.reload();
                    }
                },
                cache: false,

            });
        }
    }

    $(document).ready(function (){

        $("#placebidModal1 .selects#mainCategory").select2({
            dropdownParent: $('#placebidModal1')
        });
        $("#editModal .selects#m_mainCategory").select2({
            dropdownParent: $('#editModal')
        });




        var table = $('#kt_datatable');
        table.DataTable({
            responsive: true,
            searchDelay: 500,
            "language":{
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },
            dom:'rtip',
            serverSide: true,
            order: [[0, "asc"]],
            ajax: {
                url: "<?= base_url("get-user-bank-list") ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'token','banka_adi','type','created_at','status','banka_sahip','banka_iban','action'],
                },
            },

            columns: [
                {data: 'banka_adi',orderable: false, searchable: false,},
                {data: 'type',orderable: false, searchable: false,},
                {data: 'banka_iban',searchable: false, responsivePriority:0},
                {data: 'banka_sahip', responsivePriority: 0},
                {data: 'created_at', responsivePriority: -2},
                {data: 'status', responsivePriority: -2},
                {data: 'action', responsivePriority: 0, searchable: false, className: ""},
            ],
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    targets: 0,
                },
                {
                    orderable: false,
                    searchable: true,
                    visible: true,
                    targets: 1,
                    "render": function (data, type, row) {
                        if(row.type==1){
                            return "<?= langS(204,2) ?>"  ;
                        }else{
                            return  "<?= langS(205,2) ?>"  ;
                        }
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
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 5,
                    render: function (data, type, row) {
                        if(row.status==1){
                            return '<span style="padding:10px; border-radius: 10px;font-size:14px; " class="text-white bg-success"><i class="fa fa-check"></i> <?= ($_SESSION["lang"]==1)?"Aktif":"Active"; ?></span>';
                        }else{
                            return '<span style="padding:10px; border-radius: 10px;font-size:14px; " class="text-white bg-danger"><i class="fa fa-times"></i> <?= ($_SESSION["lang"]==1)?"Pasif":"Passive"; ?></span>';

                        }
                    }
                },

                {
                    targets: -1,
                    title: 'İşlemler',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return '<a href="javascript:;" onclick="editModal(\'' + row.token +  '\')" href="" style="margin-right:10px;cursor:pointer" ><i class="fa fa-edit text-info"></i></a>' +
                            '<a  onclick="deleteModal(\'' + row.token +  '\')" href="javascript:;" style="margin-right:10px;cursor:pointer" ><i class="fa fa-trash text-danger"></i></a>';


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
                    url: "<?= base_url("add-user-bank") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                if (response.type == "validation") {
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    $("#submitButton").prop("disabled", false);
                                    $("#submitButton").html("<?= langS(206,2) ?>");
                                }else if(response.type="oturum"){
                                    window.location.reload();
                                } else {
                                    toastr.warning(response.message);
                                    $("#submitButton").prop("disabled", false);
                                    $("#submitButton").html("<?= langS(206,2) ?>");
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

        $("#editForm").validate({
            rules: {

            },
            messages: {

            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("editForm"));
                $("#m_submitButton").prop("disabled", true);
                $("#m_submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
                $.ajax({
                    url: "<?= base_url("update-user-bank") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                if (response.type == "validation") {
                                    $("#m_uyCont .alert").html(response.message);
                                    $("#m_uyCont").fadeIn(500);
                                    $("#m_submitButton").prop("disabled", false);
                                    $("#m_submitButton").html("<?= langS(206,2) ?>");
                                }else if(response.type="oturum"){
                                    window.location.reload();
                                } else {
                                    toastr.warning(response.message);
                                    $("#m_submitButton").prop("disabled", false);
                                    $("#m_submitButton").html("<?= langS(206,2) ?>");
                                }
                            } else {
                                $(".deleted").remove();
                                $("#m_uyCont .alert").removeClass("alert-danger").addClass("alert-success");
                                $("#m_uyCont .alert").html(response.message);
                                $("#m_uyCont").fadeIn(500);
                                $("#m_submitButton").remove();
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

        $("#deleteButton").on("click",function (){
           if($("#ssToken").val()){
               $.ajax({
                   url: "<?= base_url("set-delete-bank?t=2") ?>",
                   type: 'POST',
                   data: {data:$("#ssToken").val()},
                   success: function (response) {
                       if (response) {
                           if (response.hata == "var") {
                               $("#uy .alert").addClass("alert-warning");
                               $("#uy .alert").html(response.message);
                               toastr.warning(response.message);
                               $("#uy").fadeIn(200);
                           } else {
                               $(".deleted ").remove();
                               $("#uy .alert").addClass("alert-success").removeClass("alert-warning");
                               $("#uy .alert").html(response.message);
                               $("#uy").fadeIn(200);
                               toastr.success(response.message);
                               setTimeout(function (){
                                   window.location.reload();
                               },1500)
                           }
                       } else {
                           window.location.reload();
                       }
                   },
                   cache: false,

               });
           }
        });



    });
</script>