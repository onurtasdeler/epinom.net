<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
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
            url: "<?= base_url("get-payment-list/paytr") ?>",
            type: 'POST',
            data: {
                // parameters for custom backend script demo
                columnsDef: [
                    'sipNo','price','tarih','com','description','odenecek','durum','link','action'],
            },
        },

        columns: [

            {data: 'sipNo',orderable: false, searchable: false,},
            {data: 'tarih',orderable: false, searchable: false,},
            {data: 'odenecek', searchable: false},
            {data: 'price', searchable: false},
            {data: 'durum', responsivePriority: 0},
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
                    }else if(row.durum==4){
                        return '<b class="text-danger"><i class="fa fa-times "></i> Reddedildi - <br>  </b>';
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

    $paytr = getTableSingle("table_payment_methods", array("id" => 1));
    if($paytr->status==1){
    ?>
    $("#pricePaytrCredi").on("input keyup change",function (){
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



        var vals=$(this).val();
        if(vals && vals>0 && vals<10000000){
            $.ajax({
                url:"<?= base_url() ?>get-balance-com",
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
                            $("#pko").html(response.odenecek + " <?= getcur() ?>");
                            $("#pks").html(response.komisyon + " <?= getcur() ?>");
                            $("#pkb").html(response.price + " <?= getcur() ?>");
                        }
                    }
                },
            });
        }else{
            $("#pricePaytrCredi").val("");
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
    $("#btnPaytrCredit").on("click",function (){
        var vals=$("#pricePaytrCredi").val();
        if(vals && vals>0 && vals<10000000){
            $.ajax({
                url:"<?= base_url() ?>get-paytr-iframe-kredit",
                type: 'POST',
                data: {price:vals,lang:"<?= $_SESSION["lang"] ?>"},
                success: function (response) {
                    if(response){
                        if(response.hata=="var"){
                            if(response.type){
                                //window.location.reload();
                            }else{
                                toastr.warning(response.message);
                            }
                        }else{

                            $("#btnPaytrCredit").remove();
                            $("#paytrCreditIframe").html(response.veri);
                            $("#paytrCreditIframe").fadeIn(500);
                            iFrameResize({},'#paytriframe');


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
    $("#paytrCreditIframe").on('load', function(){
        var currentSrc = this.contentWindow.location.href;
        var cleanSrc = currentSrc.replace("?#", "");
        if (currentSrc !== cleanSrc) {
            this.contentWindow.location.href = cleanSrc;
        }
    });
</script>