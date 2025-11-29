<script src="<?= base_url("assets/js/") ?>select2.min.js"></script>

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
    $satislar=getLangValue(54,"table_pages");

    ?>


    function copyToClipboard(kod) {
        navigator.clipboard.writeText(kod);
        toastr.success("<?=  langS(238,2) ?>")
    }
    function modalShow(sip){
        if(sip){
            $.ajax({
                url:"<?= base_url() ?>get-info-order-ad",
                type: 'POST',
                data: {sipNo:sip},
                success: function (response) {
                    if(response){
                        $("#copyButton").attr("data-id",response.codes);
                        $("#mTarih").html(" " + response.cre + " ");
                        $("#mTeslim").html(" " + response.teslim + " ");
                        $("#mSipNo").html(" #" + response.sipNo + " ");
                        $("#mCode").html(" " + response.codes + " ");
                        $("#mSipNoo").html(" #" + response.sipNo + " ");
                        $("#mStore").html("<a style='display:inline-block' href='" + response.mLink + "' target='_blank'><img class='rounded' src='<?= base_url("upload/users/store/") ?>" + response.mLogo + "' width='20px'> " + response.mName + " </a>");
                        $("#mAds").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                        $("#mPrice").html(" " + response.price + " ");
                        $("#placebidModal1").modal("show");
                    }else{

                    }

                },
            });

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

    function modalShowReport(sip){
        if(sip){
            $.ajax({
                url:"<?= base_url() ?>get-info-order-ad?t=2",
                type: 'POST',
                data: {sipNo:sip},
                success: function (response) {
                    if(response){
                        $("#reportSip").html("#" +response.sipNo + "<?= ($_SESSION["lang"] == 1)?" - Siparişi Bildir":" - Order Report" ?>");
                        if(response.destek==1){
                            $("#m2SipNoo").html( "#" + response.sipNo );
                            $("#m2Tarih").html(response.cre );
                            $("#m2Ads").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                            $("#m2Store").html("<a style='display:inline-block' href='" + response.mLink + "' target='_blank'><img class='rounded' src='<?= base_url("upload/users/store/") ?>" + response.mLogo + "' width='20px'> " + response.mName + " </a>");
                            $("#m2Price").html(" " + response.price + " ");
                            $("#kponus").val("");
                            $("#tokenss").val("");
                            $("#supportForm").hide();
                            $("#uys .alert").html(response.str);
                            $("#uys").show();
                            $("#placebidModal2").modal("show");
                        }else{
                            $("#m2SipNoo").html( "#" + response.sipNo );
                            $("#supportForm").show();
                            $("#m2Tarih").html(response.cre );
                            $("#uys .alert").html("");
                            $("#uys").hide();
                            $("#m2Ads").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                            $("#m2Store").html("<a style='display:inline-block' href='" + response.mLink + "' target='_blank'><img class='rounded' src='<?= base_url("upload/users/store/") ?>" + response.mLogo + "' width='20px'> " + response.mName + " </a>");
                            $("#m2Price").html(" " + response.price + " ");
                            $("#kponus").val(response.konu);
                            $("#tokenss").val(response.sipNo);
                            $("#placebidModal2").modal("show");
                        }
                    }

                },
            });

        }
    }


    function modalShowCancel(sip){
        if(sip){
            $.ajax({
                url:"<?= base_url() ?>get-info-order-ad",
                type: 'POST',
                data: {sipNo:sip},
                success: function (response) {
                    if(response){
                        $("#reportSip2").html("#" +response.sipNo + "<?= ($_SESSION["lang"] == 1)?" - Siparişi İptal Et":" - Order Cancel   " ?>");
                        $("#m22SipNoo").html( "#" + response.sipNo );
                        $("#m22Tarih").html(response.cre );
                        $("#tokent").val(response.sipNo);
                        $("#m22Ads").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                        $("#m22Store").html("<a style='display:inline-block' href='" + response.mLink + "' target='_blank'><img class='rounded' src='<?= base_url("upload/users/store/") ?>" + response.mLogo + "' width='20px'> " + response.mName + " </a>");
                        $("#m22Price").html(" " + response.price + " ");

                        $("#placebidModalcancel").modal("show");
                    }

                },
            });

        }
    }




    $(document).ready(function (){

        $(".selects#rating").select2({});

        $("#iptalFrom").validate({
            rules: {

            },
            messages: {

            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("iptalFrom"));
                $("#submitButtons").prop("disabled", true);
                $("#submitButtons").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
                $.ajax({
                    url: "<?= base_url("set-order-cancel") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                $("#uyCont2 .alert").html(response.message);
                                $("#uyCont2").fadeIn(500);
                                toastr.warning(response.message);
                                $("#submitButtons").prop("disabled", false);
                                $("#submitButtons").html("<?= langS(265,2) ?>");
                            } else {
                                $(".deleted").remove();
                                $("#uyCont2 .alert").removeClass("alert-danger").addClass("alert-success");
                                $("#uyCont2 .alert").html(response.message);
                                $("#uyCont2").fadeIn(500);
                                $("#submitButtons").remove();
                                toastr.success(response.message);
                                setTimeout(function () {
                                    <?php
                                    $destes=getLangValue(54,"table_pages");
                                    ?>
                                    //window.location.href="<?= base_url(gg().$destes->link."?type=cancelled") ?>";
                                }, 2000);
                            }
                        } else {
                            //window.location.reload();
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
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
                    url: "<?= base_url("set-support-post?t=2") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                if (response.type == "validation") {
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    $("#submitButton").prop("disabled", false);
                                    $("#submitButton").html("<?= langS(265,2) ?>");
                                }else if(response.type="oturum"){
                                    window.location.reload();
                                } else {
                                    toastr.warning(response.message);
                                    $("#submitButton").prop("disabled", false);
                                    $("#submitButton").html("<?= langS(265,2) ?>");
                                }
                            } else {
                                $(".deleted").remove();
                                $("#uyCont .alert").removeClass("alert-danger").addClass("alert-success");
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(500);
                                $("#submitButton").remove();
                                toastr.success(response.message);
                                setTimeout(function () {
                                    <?php
                                    $destes=getLangValue(97,"table_pages");

                                    ?>
                                    window.location.href="<?= base_url(gg().$destes->link) ?>"
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
                                   window.location.reload();
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

        $("#copyButton").on("click",function (){
            copyToClipboard($(this).data("id"));
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
            order: [[1, "desc"]],
            ajax: {
                url: "<?= base_url("get-list-my-ad-orders?t=".$text) ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'sipNo','ilanAdiTr','ilanAdiEn','priceTotal','teslimAt','teslimTarihVeri','mLogo','ilanLink','cdate','stat','ilanType','action'
                    ],
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
                        let imgUrl = "";
                        if ( row.mLogo == undefined ){
                            row.mLogo = row.mAvatar;
                        }else{
                            row.mLogo = "<?= base_url("upload/users/store/") ?>" + row.mLogo;
                        }
                        return "<div><a style='display:block;font-size: 11px;text-decoration: none;' href='" + row.ilanLink + "' target='_blank' class='btn btn-success '><i class='fa fa-external-link'></i> #" + row.ilanAdiTr + "</a>  " +
                            "<a  style='display:block;font-size: 11px;text-decoration: none; margin-top:5px' href='" + row.mLink + "' target='_blank' class='btn btn-dark text-black'>" +
                            "<img  width='30px' src='" + row.mLogo + "'> " + row.mName + "</a></div>";
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
                                return "<b class='text-warning'><i class='fa fa-clock-o'></i> <?= langS(279,2)  ?>" + "</b>" +
                                    "<br> <b class='text-danger' style='line-height:30px;'>" + row.teslimTarihVeri + "  </b>" ;
                            }else{
                                return "<b class='text-warning'><i class='fa fa-clock-o'></i> <?= langS(279,2)  ?>" + "</b>" +
                                     "<br> <b class='text-danger' style='line-height:30px;'>" + row.teslimTarihVeri + "  </b>" ;
                            }
                        }else if(row.stat==1){
                            return "<b class='text-warning'><i class='fa fa-comment fa-spin'></i> <?=langS(305,2)  ?>" + "</b>";

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
                            if(row.ilanType==0){
                                return  '<a href="<?= base_url(gg().$satislar->link."/") ?>' + row.sipNo +  '" class="text-warning" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-search"></i> </a> &nbsp; ' +
                                    '<a onclick="modalShowRating(\'' + row.sipNo + '\')" style="margin-right:10px;cursor:pointer;"><img style="width:25px" src="<?= base_url("assets/img/icon/rating.png") ?>"></a>' +
                                    '<a  onclick="modalShowReport(\'' + row.sipNo + '\')" title="Sil"><img style="width:25px" src="<?= base_url("assets/img/icon/alert.png") ?>"></a>' ;
                            }else{
                                return  '<a onclick="modalShow(\'' + row.sipNo + '\')" style="margin-right:10px;cursor:pointer;"><img style="width:25px" src="<?= base_url("assets/img/icon/find.png") ?>"></a>' +
                                    '<a onclick="modalShowRating(\'' + row.sipNo + '\')" style="margin-right:10px;cursor:pointer;"><img style="width:25px" src="<?= base_url("assets/img/icon/rating.png") ?>"></a>' +
                                    '<a  onclick="modalShowReport(\'' + row.sipNo + '\')" title="Sil"><img style="width:25px" src="<?= base_url("assets/img/icon/alert.png") ?>"></a>' ;
                            }

                        }else if(row.stat==1){
                            return '<a href="<?= base_url(gg().$satislar->link."/") ?>' + row.sipNo +  '" class="text-warning" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-search"></i> <?= langS(288,2) ?></a> &nbsp; ' ;
                        }else if(row.stat==2){
                            return  '<a href="<?= base_url(gg().$satislar->link."/") ?>' + row.sipNo +  '" class="text-warning" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-search"></i> <?= langS(288,2) ?></a> &nbsp; ' +
                                '<a  onclick="modalShowReport(\'' + row.sipNo + '\')" title="Sil"><img style="width:25px" src="<?= base_url("assets/img/icon/alert.png") ?>"></a>' ;
                        }else if(row.stat==0){
                            if(row.teslimTarihDurum==2){
                                return  '<a  onclick="modalShowReport(\'' + row.sipNo + '\')" title="Sil"><img style="width:25px" src="<?= base_url("assets/img/icon/alert.png") ?>"></a>' ;

                            }else{
                                return  '<a  onclick="modalShowCancel(\'' + row.sipNo + '\')" class="text-danger" style="text-decoration:none; cursor:pointer" title="Sil"><img style="width:20px" src="<?= base_url("assets/img/icon/trash-bin.png") ?>"> İptal Et</a> ' ;
                            }
                            
                        }else if(row.stat==4    ){
                            return '<a href="<?= base_url(gg().$satislar->link."/") ?>' + row.sipNo +  '" class="text-warning" style="margin-right:10px;cursor:pointer; text-decoration:none"  title="Güncelle"><i class="fa fa-search"></i> <?= langS(288,2) ?></a> &nbsp; ' ;
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


    window.addEventListener("DOMContentLoaded",() => {
        const starRating = new StarRating("form");
    });

    class StarRating {
        constructor(qs) {
            this.ratings = [
                {id: 1, name: "Terrible"},
                {id: 2, name: "Bad"},
                {id: 3, name: "OK"},
                {id: 4, name: "Good"},
                {id: 5, name: "Excellent"}
            ];
            this.rating = null;
            this.el = document.querySelector(qs);

            this.init();
        }
        init() {
            this.el?.addEventListener("change",this.updateRating.bind(this));

            // stop Firefox from preserving form data between refreshes
            try {
                this.el?.reset();
            } catch (err) {
                console.error("Element isn’t a form.");
            }
        }
        updateRating(e) {
            // clear animation delays
            Array.from(this.el.querySelectorAll(`[for*="rating"]`)).forEach(el => {
                el.className = "rating__label";
            });

            const ratingObject = this.ratings.find(r => r.id === +e.target.value);
            const prevRatingID = this.rating?.id || 0;

            let delay = 0;
            this.rating = ratingObject;
            this.ratings.forEach(rating => {
                const { id } = rating;

                // add the delays
                const ratingLabel = this.el.querySelector(`[for="rating-${id}"]`);

                if (id > prevRatingID + 1 && id <= this.rating.id) {
                    ++delay;
                    ratingLabel.classList.add(`rating__label--delay${delay}`);
                }

                // hide ratings to not read, show the one to read
                const ratingTextEl = this.el.querySelector(`[data-rating="${id}"]`);

                if (this.rating.id !== id)
                    ratingTextEl.setAttribute("hidden",true);
                else
                    ratingTextEl.removeAttribute("hidden");
            });
        }
    }

</script>