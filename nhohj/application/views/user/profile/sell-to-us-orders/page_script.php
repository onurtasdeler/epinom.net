<script src="<?= base_url("assets/js/") ?>select2.min.js"></script>
<?php
$kat=getLangValue(105,"table_pages");
?>
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
        $text="all";
    }
    $satislar=getLangValue(54,"table_pages");

    ?>
    function downloadTextFile(content, fileName) {
        // <br> etiketlerini \n karakterlerine dönüştür
        content = content.replace(/<br>/g, '\n');
        // Metni içeren Blob oluştur
        const blob = new Blob([content], { type: 'text/plain' });

        // Blob'u URL'ye çevir
        const url = URL.createObjectURL(blob);

        // <a> elemanını oluştur ve ayarla
        const a = document.createElement('a');
        a.href = url;
        a.download = fileName;

        // Dokümana ekle, tıklamayı simüle et, ve elemanı kaldır
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);

        // URL'yi serbest bırak
        URL.revokeObjectURL(url);
        content=null;
    }

    function copyToClipboard(kod) {

        let modifiedKod = kod.replace(/<br\s*\/?>/gi, '\n');
        navigator.clipboard.writeText(modifiedKod);
        // Düzeltilmiş metni panoya kopyala
        toastr.success("<?=  langS(238,2) ?>")
    }
    function modalShow(sip,pro){
        if(sip){
            $.ajax({
                url:"<?= base_url() ?>get-info-prod-order?t=1",
                type: 'POST',
                data: {sipNo:sip,pro:pro},
                success: function (response) {
                    if(response){
                        $("#copyButton").attr("data-id",response.codesPaste);
                        $("#copyButton2").attr("data-id",response.codesPasteVia);
                        $("#mTarih").html(" " + response.cre + " ");
                        $("#mTeslim").html(" " + response.teslim + " ");
                        $("#mSipNo").html(" #" + response.sipNo + " ");
                        $("#mCode").html(" " + response.codes + " ");
                        $("#codesWord").val( response.codesPasteVia );
                        if(response.codes && response.status==2){
                            $(".codeCont").show();
                        }else{
                            $(".codeCont").hide();
                        }
                        $("#mSipNoo").html(" #" + response.sipNo + " ");
                        $("#mAds").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                        $("#mPrice").html(" " + response.price + " ");
                        $("#mPriceT").html(" " + response.price_total + " ");
                        $("#mAdet").html(" " + response.qty + " ");
                        if(response.status==2){
                            $("#mStatus").html("<b class='text-success'> <?= (lac()==1)?"Teslim Edildi":"Completed" ?> </b>");
                        }else  if(response.status==1){
                            $("#mStatus").html("<b class='text-warning'> <i class='fa fa-spinner fa-spin'></i> <?= (lac()==1)?"Bekliyor":"Waiting" ?> </b>");
                        }else  if(response.status==3){
                            $("#mStatus").html("<b class='text-warning'> <i class='fa fa-spinner fa-spin'></i> <?= (lac()==1)?"Hazırlanıyor":"Preparing" ?> </b>");
                        }else  if(response.status==5){
                            $("#mStatus").html("<b class='text-danger'> <i class='fa fa-times'></i> <?= (lac()==1)?"İptal Edildi":"Cancelled" ?> </b><br> <small class='text-danger'>" + response.rednedeni + "</small>");
                        }
                        $("#placebidModal1").modal("show");
                    }else{

                    }

                },
            });

        }
    }

    function modalShowRating(sip,pro){
        if(sip){
            $.ajax({
                url:"<?= base_url() ?>get-info-prod-order?t=1",
                type: 'POST',
                data: {sipNo:sip,pro:pro},
                success: function (response) {
                    if(response){
                        if(response.degerlendirme==1){
                            $("#ordersNo").val( response.sipNo );
                            $("#protoken").val( response.protoken );
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
                            $("#protoken").val( response.protoken );
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

    function modalShowReport(sip,pro){
        if(sip){
            $.ajax({
                url:"<?= base_url() ?>get-info-order-ad?t=2",
                type: 'POST',
                data: {sipNo:sip,pro:pro},
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
    function generateRandomFileName() {
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const length = 10;
        let randomString = '';

        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            randomString += characters.charAt(randomIndex);
        }

        const timestamp = new Date().getTime();
        return `${randomString}_${timestamp}.txt`;
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
                    url: "<?= base_url("set-orders-review") ?>",
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

        $("#placebidModal1 ").on("click","#copyButton2",function (){
            var metin = $("#codesWord").val();
            var dosyaAdi = "siparis-" + generateRandomFileName();
            downloadTextFile(metin, dosyaAdi);
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
            order: [[5, "desc"]],
            ajax: {
                url: "<?= base_url("get-list-my-selltous-orders?t=".$text) ?>",
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'sipNo','productName','link','type','total_price','status','createdAt','action'],
                },
            },
            columns: [
                {data: 'sipNo',orderable: true, searchable: false, responsivePriority:0},
                {data: 'productName', orderable: true, searchable: false,},
                {data: 'total_price', responsivePriority: 0},
                {data: 'status', responsivePriority: -2},
                {data: 'type', responsivePriority: -2},
                {data: 'createdAt', responsivePriority: -2},
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
                    orderable: false,
                    searchable: true,
                    visible: true,
                    targets: 1,
                    "render": function (data, type, row) {

                        return "<div class='row'><div class='col-lg-3'><a style='font-size: 14px;text-decoration: none;' href='" + row.link + "' target='_blank'><i class='fa fa-external-link'></i> #" + row.productName + "</a> </div>";
                    }

                },{
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets:2,
                    "render": function (data, type, row) {

                            return "<b> " + row.total_price  + " <?= getcur() ?></b>";

                    }
                },
                {
                    orderable: false,
                    searchable: false,
                    targets: 3,
                    "render": function (data, type, row) {
                        if(row.status==0){
                            return "<span class='badge bg-warning text-dark'><i class='fa fa-spinner fa-spin'></i> <?= (lac()==1)?"Bekliyor":"Waiting" ?> <br></span>  " ;
                        }else if(row.status==2){
                            return "<span class='badge badge-success bg-success text-white'><i class='fa fa-check '></i>  <?= (lac()==1)?"Teslim Edildi":"Complated" ?> <br></span>  " ;
                        }else if(row.status==1){
                            return "<span class='badge badge-success bg-warning text-dark'><i class='fa fa-spinner fa-spin'></i> <?= (lac()==1)?"Hazırlanıyor":"Pending" ?> <br></span>  " ;
                        }else if(row.status==3){
                            return "<span class='badge badge-danger bg-danger text-dark'><i class='fa fa-times '></i>  <?= (lac()==1)?"İptal Edildi":"Canceled" ?> <br></span>  " ;
                        }


                    }
                },
                {
                    orderable: false,
                    searchable: false,
                    targets: 4,
                    "render": function (data, type, row) {
                        if(row.type==0){
                            return "<span class='badge badge-success bg-success text-white'><?= (lac()==1)?"Bizden Al":"Purchase From Us" ?> <br></span>  " ;
                        }else if(row.type==1){
                            return "<span class='badge badge-success bg-danger text-white'><?= (lac()==1)?"Bize Sat":"Sell To Us" ?> <br></span>  " ;
                        }
                    }
                },{
                    orderable: true,
                    searchable: true,
                    visible: true,
                    targets:5
                },
                {
                    targets: -1,
                    title: 'İşlemler',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return  '<a class=" btn-grad  mb-4 " href="<?= base_url('al-sat-siparis-detay') ?>/'+row.sipNo+'" class="text-warning" style="justify-content: start; text-align: center !important;display:inline-block; text-decoration:none;padding-left:7px !important;padding-right:7px !important;"  title="Güncelle"><i class="fa fa-search"></i> Detay</a> &nbsp';
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