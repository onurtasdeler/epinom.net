<script src="<?= base_url("assets/js/") ?>select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function (){
        $(".selects#mainCategory").select2({
        });
        $("#amounts").prop("disabled",true);
        $("#amounts").prop("placeholder","<?= ($_SESSION["lang"]==1)?"Önce Banka Seçiniz":"Select Bank first" ?>");

        $('.selects#mainCategory').on('select2:select', function (e) {
            var data = e.params.data;
            if(data.id){
                $.ajax({
                    url: "<?= base_url("get-record-bank?t=1") ?>",
                    type: 'POST',
                    data: {data:data.id},
                    success: function (response) {
                        if(response){
                            if(response.hata=="var"){
                                $("#amounts").prop("disabled",true);
                                $("#amounts").val("");
                                $("#amounts").prop("placeholder","<?= ($_SESSION["lang"]==1)?"Önce Banka Seçiniz":"Select Bank first" ?>");
                                toastr.warning(response.message);
                            }else{
                                $("#Bname").html(response.name);
                                $("#Biban").html(response.iban);
                                $("#Bacc").html(response.hesap);
                                $("#amounts").prop("placeholder","<?= langS(224,2) ?>");
                                $("#amounts").prop("disabled",false);
                                $(".viewTable").fadeIn(300);
                            }
                        }
                    },
                });
            }else{

            }

        });
        $("#amounts").attr("min","0");
        $("#amounts").on("change input",function (e){
            var v=this.value;
            if($.isNumeric(v)){
                if(v<1000000){
                    if(v==""){
                        $("#amounts").val("");
                        $("#Bkom").html("-");
                        $("#Bamount").html("-");
                        $("#BCash").html("-");
                    }else{
                        if(v>=0){
                            $.ajax({
                                url: "<?= base_url("get-record-bank?t=1") ?>",
                                type: 'POST',
                                data: {data:$("#mainCategory").val(),amount:v},
                                success: function (response) {
                                    if(response){
                                        if(response.hata=="var"){
                                            $("#Bkom").html("-");
                                            $("#labelErr").html(response.message);
                                        }else{
                                            $("#labelErr").html("");
                                            $("#Bkom").html(response.kom);
                                            $("#Bamount").html(response.price);
                                            $("#BCash").html(response.net);
                                        }
                                    }
                                },
                            });
                        }else{
                            $("#Bkom").html("-");
                            $("#Bamount").html("-");
                            $("#BCash").html("-");
                            $("#amounts").val("");
                        }
                    }
                }else{
                    $("#amounts").val("");
                }

            }else{
                $("#Bkom").html("-");
                $("#Bamount").html("-");
                $("#BCash").html("-");
                $("#amounts").val("");

            }



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
                url: "<?= base_url("get-user-with-list") ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'token','banka_adi','send','type','tutar','cdate','stats','description','banka_sahip','banka_iban','action'],
                },
            },

            columns: [
                {data: 'tokenn',orderable: false, searchable: false,},
                {data: 'type',orderable: false, searchable: false,},
                {data: 'tutar',searchable: false, responsivePriority:0},
                {data: 'komisyon', responsivePriority: 0},
                {data: 'send', responsivePriority: 0},
                {data: 'cdate', responsivePriority: -2},
                {data: 'stats', responsivePriority: -2},
            ],
            columnDefs: [
                {
                    orderable: false,
                    searchable: false,
                    targets: 0,
                    "render": function (data, type, row) {
                        return "<b class='text-warning'>#" + row.tokenn + "</b>";
                    }
                },
                {
                    orderable: false,
                    searchable: true,
                    visible: true,
                    targets: 1,
                    "render": function (data, type, row) {
                        if(row.type==1){
                            return "<?= langS(204,2) ?> <br> <small class='text-info'>" + row.banka_iban + "</small>"  ;
                        }else{
                            return "<?= langS(205,2) ?> <br> <small class='text-info'>" + row.banka_iban + "</small>"  ;
                        }
                    }
                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 2,
                    "render": function (data, type, row) {
                       return row.tutar + " <?= getcur() ?>"
                    }
                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 3,
                    "render": function (data, type, row) {
                        return "<b class='text-danger'> " + (row.tutar/100)*row.komisyon +"<?= getcur(); ?></b>" ;
                    }
                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 4,
                    "render": function (data, type, row) {
                        return row.send + " <?= getcur() ?>"
                    }
                }, {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 5,
                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets: 6,
                    render: function (data, type, row) {
                        if(row.stats==0){
                            return '<span style="padding:10px; border-radius: 10px;font-size:14px;color:black !important " class="text-black bg-warning"><i class="fa fa-spinner fa-spin"></i> <?= ($_SESSION["lang"]==1)?"İnceleniyor":"Under review"; ?></span>';
                        }else if(row.stats==1){
                            return '<span style="padding:10px; border-radius: 10px;font-size:14px;color:white !important " class="text-white bg-success"><i class="fa fa-check "></i> <?= ($_SESSION["lang"]==1)?"Onaylandı":"Approved"; ?></span>';
                        }else{
                            if(row.description!=null){
                                return '<span style="padding:10px; border-radius: 10px;font-size:14px;color:white !important " class="text-white bg-danger"><i class="fa fa-times "></i> <?= ($_SESSION["lang"]==1)?"Reddedildi":"Cancelled"; ?></span><br><small style="display:block;margin-top:15px" class="text-danger"><i class="fa fa-warning"></i>' +row.description+ '</small>';
                            }else{
                                return '<span style="padding:10px; border-radius: 10px;font-size:14px;color:white !important " class="text-white bg-danger"><i class="fa fa-times "></i> <?= ($_SESSION["lang"]==1)?"Reddedildi":"Cancelled"; ?></span>';

                            }

                        }
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
        var table = $('#kt_datatable1');

        table.DataTable({
            responsive: true,
            "language":{
                "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
            },
            dom:'rtip',
            order: [[0, "asc"]],

            
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
                    url: "<?= base_url("add-user-with") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                if(response.type){
                                    if (response.type == "validation") {
                                        $("#uyCont .alert").html(response.message);
                                        $("#uyCont").fadeIn(500);
                                        $("#submitButton").prop("disabled", false);
                                        $("#submitButton").html("<?= langS(206,2) ?>");
                                    }else if(response.type="oturum"){
                                        window.location.reload();
                                    } else {
                                        $("#uyCont .alert").html(response.message);
                                        $("#uyCont").fadeIn(500);
                                        toastr.warning(response.message);
                                        $("#submitButton").prop("disabled", false);
                                        $("#submitButton").html("<?= langS(206,2) ?>");
                                    }
                                }else{
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
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


    });
</script>