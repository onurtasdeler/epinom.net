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
        order: [[1, "desc"]],
        ajax: {
            url: "<?= base_url("get-payment-list/papara") ?>",
            type: 'POST',
            data: {
                // parameters for custom backend script demo
                columnsDef: [
                    'sipNo','price','tarih','com','odenecek','durum','link','action'],
            },
        },

        columns: [
            {data: 'sipNo',orderable: false, searchable: false,},
            {data: 'tarih',orderable: false, searchable: false,},
            {data: 'odenecek', searchable: false},
            {data: 'price', searchable: false},
            {data: 'durum', responsivePriority: 0},
            {data: 'action', responsivePriority: 0, searchable: false, className: ""},
        ],
        columnDefs: [

            {
                orderable: false,
                searchable: false,
                targets: 0,
                "render": function (data, type, row) {
                    return " # " + row.sipNo  ;
                }
            }, {
                orderable: false,
                searchable: false,
                targets: 1,
            },
            {
                orderable: false,
                searchable: true,
                visible: true,
                targets: 2,
            },{
                orderable: false,
                searchable: true,
                visible: true,
                targets: 3,
            },
            {
                orderable: true,
                searchable: true,
                visible: true,
                targets: 4,
                render: function (data, type, row) {
                    if(row.durum==0){
                        return '<b class="text-warning"><i class="fa fa-spinner fa-spin"></i> İşlemde </b>';
                    }else if(row.durum==1){
                        return '<b class="text-success"><i class="fa fa-check "></i> Ödendi </b>';
                    }else if(row.durum==2){
                        return '<b class="text-danger"><i class="fa fa-times "></i> Ödenmedi </b>';
                    }else{

                    }
                    return '<a href="<?= base_url(gg()) ?>' + row.sipNo + '" style="margin-right:10px;cursor:pointer"  title="Güncelle"><i class="fa fa-edit text-info"></i></a>';
                }
            },

            {
                targets: -1,
                title: 'İşlemler',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    if(row.durum==0){
                        return '<a  href="' + row.link + '" target="_blank" type="button" id="" class="btn btn-warning text-dark btn-small " style="margin-right: 10px;text-decoration:none"><i class="fa fa-credit-card"></i> Öde </a>';
                    }else if (row.durum==1){
                        return '<span class="badge badge-success bg-success text-white "   style="margin-right: 10px;text-decoration:none"><i class="fa fa-check"></i> Ödendi </span>';
                    }else if (row.durum==2){
                        return '<span class="badge badge-success bg-danger text-white " style="margin-right: 10px;text-decoration:none"><i class="fa fa-times"></i> Ödenmedi  </a>';
                    }else{

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

    $papara = getTableSingle("table_payment_methods", array("id" => 4));
    if($papara->status==1){
    ?>
    $('#pricePaparaCredi').on('input', function() {
        var input = $(this);
        var value = input.val();

        // Rakamlar, nokta ve virgül dışındaki karakterleri temizle
        var filteredValue = value.replace(/[^\d,.]/g, '');

        // Daha önce işlenmiş değer ve imleç pozisyonunu sakla
        var oldValue = input.data('oldValue') || '';
        var oldSelectionStart = input[0].selectionStart;

        // Virgül ve noktayı noktaya dönüştür ve fazla noktaları temizle
        var newValue = filteredValue.replace(/,/g, '.').replace(/(\..*)\./g, '$1');

        // Noktadan sonra en fazla iki rakam olmasını sağla
        var parts = newValue.split('.');
        if (parts.length > 1) {
            parts[1] = parts[1].substring(0, 2); // sadece ilk iki hane
            newValue = parts[0] + '.' + parts[1];
        }

        // Değiştirilen değeri ve imleç pozisyonunu güncelle
        input.val(newValue);
        var newSelectionStart = oldSelectionStart + (newValue.length - filteredValue.length);
        input[0].setSelectionRange(newSelectionStart, newSelectionStart);

        // Değiştirilmiş değeri sakla
        input.data('oldValue', newValue);
    });
    $("#pricePaparaCredi").on("input keyup change",function (){
        var vals=$(this).val();
        if(vals && vals>0 && vals<10000000){
            $.ajax({
                url:"<?= base_url() ?>get-balance-com",
                type: 'POST',
                data: {types:4,price:vals,lang:"<?= $_SESSION["lang"] ?>"},
                success: function (response) {
                    if(response){
                        if(response.hata=="var"){
                            if(response.type){
                                window.location.reload();
                            }else{
                                toastr.warning(response.message);
                            }
                        }else{
                            $("#pko").html(response.odenecek + " <?= getcur() ?>");
                            $("#pks").html(response.komisyon + " <?= getcur() ?>");
                            $("#pkb").html(response.price + " <?= getcur() ?>");
                        }
                    }
                },
            });
        }else{
            $("#pricePaparaCredi").val("");
            $("#pko").html("-");
            $("#pks").html("-");
            $("#pkb").html("-");
        }
    });
    $(".ppricePaytrHavale").on("input keyup change",function (){
        var tok=$(this).data("tok");
        var vals=$(this).val();
        if(vals && vals>0 && vals<10000000){
            $.ajax({
                url:"<?= base_url() ?>get-balance-com-eft",
                type: 'POST',
                data: {types:1,price:vals,lang:"<?= $_SESSION["lang"] ?>"},
                success: function (response) {
                    if(response){
                        if(response.hata=="var"){
                            if(response.type){
                                window.location.reload();
                            }else{
                                toastr.warning(response.message);
                            }
                        }else{
                            $("#pko_" + tok).html(response.odenecek + " <?= getcur() ?>");
                            $("#pks_" + tok).html(response.komisyon + " <?= getcur() ?>");
                            $("#pkb_" + tok).html(response.price + " <?= getcur() ?>");
                        }
                    }
                },
            });
        }else{
            $(".ppricePaytrHavale").val("");
            $("#pko_" + tok).html("-");
            $("#pks_" + tok).html("-");
            $("#pkb_" + tok).html("-");
        }
    });
    $(".btnPaytrHavale").on("click",function (){
        var tok=$(this).data("tok");
        var a= $('input[name="ck2"]:checked').val();
        var vals=$("#pricePaytrHavale_" + tok ).val();
        if(vals && vals>0 && vals<10000000){
            if(a){
                $.ajax({
                    url:"<?= base_url() ?>get-paytr-iframe-havale",
                    type: 'POST',
                    data: {price:vals,banks:a,lang:"<?= $_SESSION["lang"] ?>"},
                    success: function (response) {
                        if(response){
                            if(response.hata=="var"){
                                if(response.type){
                                    window.location.reload();
                                }else{
                                    toastr.warning(response.message);
                                }
                            }else{
                                $(".btnPaytrHavale").remove();
                                $("#paytrCreditIframe").html(response.veri);
                                $("#paytrCreditIframe").fadeIn(500);
                            }
                        }
                    },
                });
            }else{
                toastr.warning("<?= ($_SESSION["lang"]==1)?"Banka Seçiniz":"Bank Select" ?>");
            }
        }else{
            toastr.warning("<?= langs(48,2) ?>");
        }
    });
    $("#btnPaparaCredit").on("click",function (){
        var vals=$("#pricePaparaCredi").val();
        if(vals && vals>0 && vals<10000000){
            $("#btnPaparaCredit").prop("disabled",true);
            $("#btnPaparaCredit").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
            $.ajax({
                url:"<?= base_url() ?>get-papara-credit",
                type: 'POST',
                data: {price:vals,lang:"<?= $_SESSION["lang"] ?>"},
                success: function (response) {
                    if(response){
                        if(response.hata=="var"){
                            if(response.type){
                                window.location.reload();
                            }else{
                                $("#btnPaparaCredit").prop("disabled",false);
                                $("#btnPaparaCredit").html("<?= langS(40,2) ?>");
                                toastr.warning(response.message);
                            }
                        }else{
                            $(".deleted").remove();
                            $("#yonlendir").fadeIn(200);
                            setTimeout(function (){
                                var a = $('<a>', {
                                    href: response.veri,
                                    target: '_blank'
                                });
                                a.get(0).click();
                                setTimeout(function (){
                                    window.location.reload();
                                },1200);
                            },1500)

                        }
                    }
                },
            });
        }else{
            toastr.warning("<?= langs(48,2) ?>");
        }
    });
    <?php
    }
    ?>
</script>