<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    <?php $user=getActiveUsers();
    if($this->input->get("type")){
        $temizle=$this->input->get("type",true);
        if($temizle=="waiting"){
            $text="waited";
        }else if($temizle=="pending"){
            $text="pending";
        }else if($temizle=="completed"){
            $text="completed";
        }else if($temizle=="cancelled"){
            $text="cancelled";
        }else{
            redirect(b().gg());
        }

    }else{
        $text="waited";
    }

    $satislar=getLangValue(57,"table_pages");

    ?>




    var actives="";
    function modalShow(sip){
        if(sip){
            $.ajax({
                url:"<?= base_url() ?>get-info-order-ad",
                type: 'POST',
                data: {sipNo:sip,type:1},
                success: function (response) {
                    $("#placebidModal1 .bid-content-mid").html(`
                            <div class="bid-content-left">
                                <span><?= langS(234) ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "Tarih" : "Date" ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "İlan" : "Ads" ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "Alıcı" : "Buyer" ?></span>
                                <span><?= ($_SESSION["lang"] == 1) ? "Tutar" : "Price" ?></span>
                            </div>
                            <div class="bid-content-right">
                                <span id="mSipNoo"></span>
                                <span id="mTarih"></span>
                                <span id="mAds"></span>
                                <span id="mStore"></span>
                                <span id="mPrice" style="color:var(--color-primary)"></span>
                            </div>`);
                    if(response){
                        actives=response.sipNo;
                        $("#copyButton").attr("data-id",response.codes);
                        $("#mTarih").html(" " + response.cre + " ");
                        $("#mTeslim").html(" " + response.teslim + " ");
                        $("#mSipNo").html(" #" + response.sipNo + " ");
                        $("#mCode").html(" " + response.codes + " ");
                        $("#mSipNoo").html(" #" + response.sipNo + " ");
                        $("#mStore").html("<img class='rounded' src='<?= base_url("upload/avatar/") ?>" + response.mLogo + "' width='20px'> " + response.mName + "");
                        $("#mAds").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                        $("#mPrice").html(" " + response.price + " ");
                        Object.entries(response.specialFields).forEach(([key, value]) => {
                            $("#placebidModal1 .bid-content-left").append("<span>"+ key +"</span>");
                            $("#placebidModal1 .bid-content-right").append("<span>"+ value +"</span>");
                        });
                        $("#placebidModal1").modal("show");
                    }else{
                        actives="";
                    }

                },
            });

        }else{
            actives="";
        }
    }

    function modalShowRating(sip){
        if(sip){
            $.ajax({
                url:"<?= base_url() ?>get-info-order-ad?t=1",
                type: 'POST',
                data: {sipNo:sip},
                success: function (response) {
                    if(response){
                        if(response.degerlendirme==1){
                            $("#ordersNo").val( response.sipNo );
                            $("#mmTarih").html(" " + response.cre + " ");
                            $("#mmTeslim").html(" " + response.teslim + " ");
                            $("#mmSipNo").html(" #" + response.sipNo + " ");

                            $("#mScore").html(" " + response.score + " ");
                            $("#mComment").html(" " + response.comment + " ");
                            $("#mCTarih").html(" " + response.date + " ");
                            $("#mCStatus").html(" " + response.cstatus + " ");

                            $("#mScore").show();
                            $("#mComment").show();
                            $("#mCTarih").show();
                            $("#mCStatus").show();
                            $(".commentY").show();

                            $("#commentForm").hide();
                            $("#mmSipNoo").html(" #" + response.sipNo + " ");
                            $("#mmStore").html("<a style='display:inline-block' href='" + response.mLink + "' target='_blank'><img class='rounded' src='<?= base_url("upload/users/store/") ?>" + response.mLogo + "' width='20px'> " + response.mName + " </a>");
                            $("#mmAds").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                            $("#placebidModalComment").modal("show");
                        }else{
                            $("#mScore").show();
                            $("#mComment").show();
                            $("#mCTarih").show();
                            $("#mCStatus").show();
                            $(".commentY").hide();
                            $("#mScore").html("");
                            $("#mComment").html("");
                            $("#mCTarih").html("");
                            $("#mCStatus").html("");

                            $("#ordersNo").val( response.sipNo );
                            $("#mmTarih").html(" " + response.cre + " ");
                            $("#commentForm").show();
                            $("#beforeComment").html("");
                            $("#beforeComment").hide();
                            $("#mmTeslim").html(" " + response.teslim + " ");
                            $("#mmSipNo").html(" #" + response.sipNo + " ");
                            $("#mmSipNoo").html(" #" + response.sipNo + " ");
                            $("#mmStore").html("<a style='display:inline-block' href='" + response.mLink + "' target='_blank'><img class='rounded' src='<?= base_url("upload/users/store/") ?>" + response.mLogo + "' width='20px'> " + response.mName + " </a>");
                            $("#mmAds").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                            $("#placebidModalComment").modal("show");
                        }

                    }

                },
            });

        }
    }


    $(document).ready(function (){

        $("#confirmButton").on("click",function (){
            if(actives){
                $("#confirmButton").prop("disabled",true);
                $.ajax({
                    url:"<?= base_url() ?>set-seller-delivery-confirm",
                    type: 'POST',
                    data: {sipNo:actives,type:1},
                    success: function (response) {
                        if(response){
                            if(response.hata=="var"){
                                $("#confirmButton").prop("disabled",false);
                                $("#uyaris").fadeIn(200);
                                $("#uyaris .alert").html(response.message);
                                toastr.warning(response.message);
                            }else{
                                $("#confirmButton").remove();
                                $("#uyaris .alert").removeClass("alert-warning").addClass("alert-success");
                                $("#uyaris .alert").html(response.message);
                                $("#uyaris").fadeIn(200);
                                toastr.success(response.message);
                                setTimeout(function(){
                                   window.location.href="<?= base_url(gg().getLangValue(57,"table_pages")->link."/") ?>" + actives;
                                },1400);
                            }
                        }else{
                            $("#confirmButton").prop("disabled",false);
                            actives="";
                            toastr.warning("<?=langS(22,2)  ?>");
                        }

                    },
                });
            }

        });


        $("#commentForm").validate({
            rules: {
                rating: {
                    required:true,
                },
                comment: {
                    required:true,
                    minlength: 20,
                    maxlength: 200,
                }
            },

            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("commentForm"));
                $("#submitButtons").prop("disabled",true);
                $("#submitButtons").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
                $.ajax({
                    url: "<?= base_url("set-order-review") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if(response){
                            if(response.hata=="var"){
                                toastr.warning(response.message);
                                $("#uyCont .alert").removeClass("alert-success").addClass("alert-warning");
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(200);
                                $("#submitButtons").prop("disabled",false);
                                $("#submitButtons").html("<i class='fa fa-check'></i> <?= langS(240,2) ?>");
                            }else{
                                $(".deleted").remove();
                                $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(500);
                                toastr.success(response.message);
                                $("#submitButtons").prop("disabled",false);
                                $("#submitButtons").html("<i class='fa fa-check'></i> <?= langS(240,2) ?>");
                                setTimeout(function (){
                                    // window.location.reload();
                                },1200);
                            }
                        }else{
                            toastr.warning("Ağınızda beklenmedik bir hata meydana geldi. Lütfen tekrar deneyiniz");
                            $("#submitButton").prop("disabled",false);
                            $("#submitButton").html("<i class='fa fa-check'></i> <?= langS(240,2) ?>");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

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
            order: [[1, "asc"]],
            ajax: {
                url: "<?= base_url("get-list-my-sell-orders?t=".$text) ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'sipNo','ilanAdiTr','ilanAdiEn','priceTotal','teslimAt','teslimTarihVeri','mLogo','ilanLink','cdate','stat','ilanType','action'],
                },
            },
            columns: [
                {data: 'sipNo',orderable: true, searchable: false, responsivePriority:0},
                {data: 'cdate', orderable: true, searchable: false,},
                {data: 'ilanAdiTr', responsivePriority: 0},
                {data: 'priceTotal', responsivePriority: -2},
                {data: 'stat', responsivePriority: 0},
                {data: 'action', responsivePriority: 0, searchable: false, className: ""},
            ],
            columnDefs: [
                {
                    orderable: true,
                    searchable: false,
                    visible: true,
                    targets: 0,
                    "render": function (data, type, row) {
                        return "<span  style='font-size: 11px;width:100%;text-decoration: none;'  href='#' class='badge bg-secondary text-white '> #" + row.sipNo + "</span>" ;
                    }
                },
                {
                    orderable: true,
                    targets: 1,
                    searchable: false,
                    "render": function (data, type, row) {
                        return "<b>" + row.cdate + "</b>";
                    }

                },
                {
                    orderable: false,
                    searchable: true,
                    visible: true,
                    targets: 2,
                    "render": function (data, type, row) {

                        return "<a style='font-size: 11px;text-decoration: none;' href='" + row.ilanLink + "' target='_blank' class='btn btn-success '><i class='fa fa-external-link'></i> #" + row.ilanAdiTr + "</a> <br><br>  " +
                            "<img  width='20px' src='<?= base_url("upload/avatar/") ?>" + row.mLogo + "'> " + row.mName + "";
                    }

                },
                {
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets:3,
                    "render": function (data, type, row) {

                        return "<b> " + row.priceTotal  + "</b>";

                    }
                },
                {
                    orderable: false,
                    searchable: false,
                    targets: 4,
                    "render": function (data, type, row) {
                        if (row.stat == 3) {
                            return "<span class='badge badge-success bg-success text-white'><i class='fa fa-check'></i> <?= langS(235,2)  ?> <br><br> "  + row.teslimAt + "  <br></span>  " ;
                        }else if(row.stat==0){
                            if(row.teslimTarihDurum==2){
                                return "<b class='text-warning'><i class='fa fa-clock-o'></i> <?= langS(282,2)  ?>" + "</b>" ;
                            }else{
                                return "<b class='text-warning'><i class='fa fa-clock-o'></i> <?= langS(282,2)  ?>" + "</b>" ;
                            }
                        }else if(row.stat==1){
                            return "<b class='text-warning'><i class='fa fa-comment fa-spin'></i> <?=langS(285,2)  ?>" + "</b>";

                        }else if(row.stat==4){
                            return "<b class='text-danger'><i class='fa fa-times fa-spin'></i> <?=langS(320,2)  ?>" + "</b>";

                        }else if(row.stat==2){
                            return "<span class='badge badge-success bg-warning text-dark'><i class='fa fa-spinner fa-spin'></i> <?= langS(330,2)  ?> <br></span>  " ;

                        }
                    }
                },
                {
                    targets: -1,
                    title: 'İşlemler',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        if(row.stat==3){
                            return  '<a href="<?= base_url(gg().$satislar->link."/") ?>' + row.sipNo +  '" class="text-warning" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-search"></i> <?= langS(288,2) ?></a> &nbsp; ';
                        }else if(row.stat==0){
                            if(row.teslimTarihDurum==2){
                                return '<a onclick="modalShow(\'' + row.sipNo + '\')" class="text-success" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-check"></i> <?= langS(286,2) ?></a> &nbsp; ' ;

                            }else{
                                return '<a onclick="modalShow(\'' + row.sipNo + '\')" class="text-success" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-check"></i> <?= langS(286,2) ?></a> &nbsp; ' +
                                    '' +
                                    '<a  onclick="modalGoster2(\'' + row.sipNo + '\')" class="text-danger" style="text-decoration:none; cursor:pointer" title="Sil"><img style="width:20px" src="<?= base_url("assets/img/icon/trash-bin.png") ?>"> <?= langS(287,2) ?></a> ' ;
                            }
                        }else if(row.stat==1){
                                return '<a href="<?= base_url(gg().$satislar->link."/") ?>' + row.sipNo +  '" class="text-warning" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-search"></i> <?= langS(288,2) ?></a> &nbsp; ' ;
                        }else if(row.stat==4    ){
                                return '<a href="<?= base_url(gg().$satislar->link."/") ?>' + row.sipNo +  '" class="text-warning" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-search"></i> <?= langS(288,2) ?></a> &nbsp; ' ;
                        }else if(row.stat==2    ){
                            return  '<a href="<?= base_url(gg().$satislar->link."/") ?>' + row.sipNo +  '" class="text-warning" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-search"></i> <?= langS(288,2) ?></a> &nbsp; ';

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
    });






</script>