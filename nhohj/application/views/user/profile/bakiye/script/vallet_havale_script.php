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
            url: "<?= base_url("get-payment-list/vallet-havale") ?>",
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
                        return '<a  href="' + row.link + '" type="button" id="" class="btn btn-warning text-dark btn-small " style="margin-right: 10px;text-decoration:none"><i class="fa fa-credit-card"></i> Öde </a>';
                    }else if (row.durum==1){
                        return '<a  href="' + row.link + '" type="button" target="_blank" id="" class="btn btn-success btn-small " style="margin-right: 10px;text-decoration:none"><i class="fa fa-check"></i> Detay </a>';
                    }else if (row.durum==2){
                        return '<a  href="' + row.link + '" type="button" target="_blank" id="" class="btn btn-danger btn-small " style="margin-right: 10px;text-decoration:none"><i class="fa fa-times"></i>  Detay </a>';
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
    $(".bildirHavaleButton").on("click",function(){
        var da=$(this).data("tok");
        if(da){
            $("#yuklemeBox" + da).fadeIn("200");
        }
    })
    $("#priceValletCredi").on("input keyup change",function (){
        var vals=$(this).val();
        if(vals && vals>0 && vals<100000){
            $.ajax({
                url:"<?= base_url() ?>get-balance-com",
                type: 'POST',
                data: {types:3,price:vals,lang:"<?= $_SESSION["lang"] ?>"},
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
    $('.ppvallethavale').on('input', function() {
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
    $(".ppvallethavale").on("input keyup change",function (){
        var vals=$(this).val();
        if(vals && vals>0 && vals<1000000){
            $.ajax({
                url:"<?= base_url() ?>get-balance-com-eft",
                type: 'POST',
                data: {types:3,price:vals,lang:"<?= $_SESSION["lang"] ?>"},
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
    $("#btnValletCredit").on("click",function (){
        var vals=$("#priceValletCredi").val();

        if(vals && vals>0 && vals<100000){
            $("#btnValletCredit").prop("disabled",true);
            $("#btnValletCredit").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
            $.ajax({
                url:"<?= base_url() ?>get-vallet-payment",
                type: 'POST',
                data: {price:vals,lang:"<?= $_SESSION["lang"] ?>"},
                success: function (response) {
                    if(response){
                        if(response.hata=="var"){
                            if(response.type){
                                window.location.reload();
                            }else{
                                $("#btnValletCredit").prop("disabled",false);
                                $("#btnValletCredit").html("<?= langS(40,2) ?>");
                                toastr.warning(response.message);
                            }
                        }else{
                            $(".deleted").remove();
                            $("#yonlendir").fadeIn(200);
                            setTimeout(function (){
                                var a = $('<a>', {
                                    href: response.link,
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
    $(".btnValletHavale").on("click",function (){
        var tok=$(this).data("tok");
        var vals=$("#priceValletHavale_" + tok).val();

        if(vals && vals>0 && vals<100000){
            $(".btnValletHavale").prop("disabled",true);
            $(".btnValletHavale").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
            $.ajax({
                url:"<?= base_url() ?>get-vallet-payment",
                type: 'POST',
                data: {price:vals,lang:"<?= $_SESSION["lang"] ?>",type:1},
                success: function (response) {
                    if(response){
                        if(response.hata=="var"){
                            if(response.type){
                                window.location.reload();
                            }else{
                                $(".btnValletHavale").prop("disabled",false);
                                $(".btnValletHavale").html("<?= langS(40,2) ?>");
                                toastr.warning(response.message);
                            }
                        }else{
                            $(".deleted").remove();
                            $("#yonlendir").fadeIn(200);
                            setTimeout(function (){
                                var a = $('<a>', {
                                    href: response.link,
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
</script>