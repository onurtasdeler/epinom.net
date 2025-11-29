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
            url: "<?= base_url("get-payment-list/manuel") ?>",
            type: 'POST',
            data: {
                // parameters for custom backend script demo
                columnsDef: [
                    'sipNo','price','tarih','ad_soyad','banka','description','red_nedeni','odenecek','durum','action'],
            },
        },

        columns: [
            {data: 'sipNo',orderable: false, searchable: false,},
            {data: 'sipNo',orderable: false, searchable: false,},
            {data: 'tarih',orderable: false, searchable: false,},
            {data: 'banka',orderable: false, searchable: false,},
            {data: 'price', searchable: false},
            {data: 'ad_soyad', searchable: false},
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
            },{
                orderable: false,
                searchable: true,
                visible: true,
                targets: 4,
            },{
                orderable: false,
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

    <?php
    /*MANUEL*/
    $manuel = getTableSingle("table_payment_methods", array("id" => 2));
    if($manuel->status==1){
    ?>
    $(".apriceManuel").on("input keyup change",function (){
        var vals=$(this).val();
        if(vals && vals>0 && vals<100000){

        }else{
            $("#pricePaytrCredi").val("");
            $("#pko").html("-");
            $("#pks").html("-");
            $("#pkb").html("-");
        }
    });
    $('.anamesurname').on('input', function () {
        var deger = $(this).val();

        // Sadece harf ve boşluk kontrolü
        if (!/^[a-zA-ZğüşıöçĞÜŞİÖÇ\s]*$/.test(deger)) {
            // İstenmeyen karakterleri kaldır
            $(this).val(deger.replace(/[^a-zA-ZğüşıöçĞÜŞİÖÇ\s]/g, ''));
        }
    });
    $('.adate').on('input', function () {
        var deger = $(this).val();

        // Eğer değer bir tarih değilse, boş bırak
        if (!/^\d{4}-\d{2}-\d{2}$/.test(deger)) {
            alert('Lütfen geçerli bir tarih seçiniz.');
            $(this).val('');
        }
    });
    $(".bildirHavaleButton").on("click",function(){
        var da=$(this).data("tok");
        if(da){
            $("#yuklemeBox" + da).fadeIn("200");
        }
    })
    $('.adescription').on('input', function () {
        var deger = $(this).val();

        // Karakter sınırını kontrol et
        if (deger.length > 100) {
            alert('En fazla 100 karakter girebilirsiniz.');
            // Girişi 100 karakterle sınırla
            $(this).val(deger.substr(0, 100));
        }
    });
    $(".manuelSubmit").on("click",function (){
        var tok= $(this).data("tok");
        var vals=$("#priceManuel_" + $(this).data("tok")).val();
        if(vals && vals>0 && vals<100000){
            var a= $('input[name="ck2"]:checked').val();

            if($.trim($("#priceManuel_" + tok).val()) && $.trim($("#namesurname_" + tok).val()) && $.trim($("#date_" + tok).val()) && $.trim($("#description_" + tok).val())){
                $(".manuelSubmit").prop("disabled",true);
                $.ajax({
                    url:"<?= base_url() ?>set-payment-manuel",
                    type: 'POST',
                    data: {price:vals,name:$.trim($("#namesurname_" + tok).val()),date: $.trim($("#date_" + tok).val()),bank:a, desc:$.trim($("#description_" + tok).val()), lang:"<?= $_SESSION["lang"] ?>"},
                    success: function (response) {
                        if(response){
                            if(response.hata=="var"){
                                if(response.type){
                                    window.location.reload();
                                }else{
                                    $("#ggg .alert").html(response.message);
                                    $("#ggg").fadeIn(200);
                                    $(".manuelSubmit").prop("disabled",false);
                                    toastr.warning(response.message);
                                }
                            }else{
                                $("#ggg").hide();
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
        }else{
            toastr.warning("<?= langs(48,2) ?>");
        }
    });
    <?php
    }
    ?>
   
</script>