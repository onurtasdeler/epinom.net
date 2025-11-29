<script>
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
            url: "<?= base_url("get-payment-list/epinkopin") ?>",
            type: 'POST',
            data: {
                // parameters for custom backend script demo
                columnsDef: [
                    'sipNo','price','tarih','kupon','description','red_nedeni','odenecek','durum','action'],
            },
        },

        columns: [
            {data: 'sipNo',orderable: false, searchable: false,},
            {data: 'sipNo',orderable: false, searchable: false,},
            {data: 'tarih',orderable: false, searchable: false,},
            {data: 'kupon', searchable: false},
            {data: 'price', searchable: false},
            {data: 'durum', responsivePriority: 0},
        ],
        columnDefs: [
            {
                orderable: false,
                searchable: false,
                targets: 0,
                "render": function (data, type, row) {
                    return " <img style=' width:50px;' src='<?= base_url("assets/images/manuel.png") ?>'>";
                }
            },
            {
                orderable: false,
                searchable: false,
                targets: 1,
                "render": function (data, type, row) {
                    return " # " + row.sipNo  ;
                }
            }, {
                orderable: false,
                searchable: false,
                targets: 2,
            },
            {
                orderable: false,
                searchable: true,
                visible: true,
                targets: 3,
            }, {
                orderable: false,
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
                    if(row.durum==0){
                        return '<b class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde </b>';
                    }else if(row.durum==1){
                        return '<b class="text-success"><i class="fa fa-check "></i> Başarılı </b>';
                    }else if(row.durum==2){
                        return '<b class="text-danger"><i class="fa fa-times "></i> Başarısız <br> <small>' + row.red_nedeni + '</small></b>';
                    }else if(row.durum==4){
                        return '<b class="text-danger"><i class="fa fa-times "></i> Başarısız - <br> <small>' + row.red_nedeni + '</small> </b>';
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
    $('#kupon').on('input', function() {
        let validValue = $(this).val().replace(/[^a-zA-Z0-9]/g, '');

        if (validValue.length > 20) {
            validValue = validValue.substring(0, 20);
        }

        $(this).val(validValue);
    });
    <?php
    /*MANUEL*/
    $manuel = getTableSingle("table_payment_methods", array("id" => 6));
    if($manuel->status==1){
    ?>

    $(".manuelSubmit").on("click",function (){
            if( $.trim($("#kupon" ).val())){
                $(".manuelSubmit").prop("disabled",true);
                $.ajax({
                    url:"<?= base_url() ?>set-payment-pin",
                    type: 'POST',
                    data: {kupon:$.trim($("#kupon" ).val())},
                    success: function (response) {
                        if(response){
                            if(response.hata=="var"){
                                if(response.type){
                                    window.location.reload();
                                }else{
                                    $("#uyaris .alert").html(response.message);
                                    $("#uyaris").fadeIn(200);
                                    $(".manuelSubmit").prop("disabled",false);
                                    toastr.warning(response.message);
                                }
                            }else{
                                $("#uyaris").hide();
                                $(".manuelSubmit").remove();
                                toastr.success(response.message);
                                setTimeout(function (){
                                    window.location.reload();
                                },1500);
                            }
                        }
                    },
                });
            }else{
                toastr.warning("<?= langs(366,2) ?>");
            }

    });
    <?php
    }
    ?>

</script>