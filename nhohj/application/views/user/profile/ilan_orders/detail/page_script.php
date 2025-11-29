<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

    <?php $user=getActiveUsers();
    $giris=getLangValue(24);
    ?>

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
                            $("#supportForm2").hide();
                            $("#uys .alert").html(response.str);
                            $("#uys").show();
                            $("#placebidModal3").modal("show");
                        }else{
                            $("#m2SipNoo").html( "#" + response.sipNo );
                            $("#supportForm2").show();
                            $("#m2Tarih").html(response.cre );
                            $("#uys .alert").html("");
                            $("#uys").hide();
                            $("#m2Ads").html("<a style='display:inline-block' href='" + response.ilanLink + "' target='_blank'>" + response.ilan + " </a>");
                            $("#m2Store").html("<a style='display:inline-block' href='" + response.mLink + "' target='_blank'><img class='rounded' src='<?= base_url("upload/users/store/") ?>" + response.mLogo + "' width='20px'> " + response.mName + " </a>");
                            $("#m2Price").html(" " + response.price + " ");
                            $("#kponus").val(response.konu);
                            $("#tokenss").val(response.sipNo);
                            $("#placebidModal3").modal("show");
                        }
                    }

                },
            });

        }
    }

    function messageLoad(d=0){
        $.ajax({
            url:"<?= base_url() ?>message-load-adverts-buyer",
            type: 'POST',
            data: {user:"<?= $user->token ?>",talep:"<?= $uniq->sipNo ?>",lang:"<?= $_SESSION["lang"] ?>"},
            success: function (response) {
                if(response){
                    $("#scrollss").html(response.str);
                    $("#scrollss").scrollTop(10000000);
                }
            },
        });


    }

    function escapeHTML(input) {
        if (!input) return '';

        // HTML özel karakterlerini etkisiz hale getir
        return input.replace(/[&<>"'/]/g, function (match) {
            return {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#39;',
                '/': '&#x2F;'
            }[match];
        });
    }


    $(document).ready(function (){
        
        $("#supportForm2").validate({
            rules: {

            },
            messages: {

            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("supportForm2"));
                $("#submitButton2").prop("disabled", true);
                $("#submitButton2").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
                $.ajax({
                    url: "<?= base_url("set-support-post?t=2") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                if (response.type == "validation") {
                                    $("#uyCont3 .alert").html(response.message);
                                    $("#uyCont3").fadeIn(500);
                                    $("#submitButton2").prop("disabled", false);
                                    $("#submitButton2").html("<?= langS(265,2) ?>");
                                }else if(response.type="oturum"){
                                    window.location.reload();
                                } else {
                                    toastr.warning(response.message);
                                    $("#submitButton2").prop("disabled", false);
                                    $("#submitButton2").html("<?= langS(265,2) ?>");
                                }
                            } else {
                                $(".deleted").remove();
                                $("#uyCont3 .alert").removeClass("alert-danger").addClass("alert-success");
                                $("#uyCont3 .alert").html(response.message);
                                $("#uyCont3").fadeIn(500);
                                $("#submitButton2").remove();
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

        messageLoad();
        setInterval(function () {
            messageLoad();
        }, 10000);



        $("#confirmButton").on("click",function (){
            $("#confirmButton").prop("disabled",true);
            $.ajax({
                url:"<?= base_url() ?>order-buyer-confirm",
                type: 'POST',
                data: {token:"<?= $uniq->sipNo ?>"},
                success: function (response) {
                    if(response){
                        if(response.hata=="var"){
                            $("#confirmButton").prop("disabled",false);
                            $("#uyaris .alert").html(response.message);
                            $("#uyaris").fadeIn(200);
                            toastr.warning(response.message);
                        }else{
                            $("#confirmButton").remove();
                            $("#uyaris .alert").removeClass("alert-warning").addClass("alert-success").html(response.message);
                            $("#uyaris").fadeIn(200);
                            toastr.success(response.message);
                            setTimeout(function (){
                                window.location.reload();
                            },1500)
                        }
                    }else{
                        toastr.warning("<?= langS(22,2) ?>");
                    }
                },
            });
        });


        $('#mesaj').keypress(function (e) {

            var key = e.which;
            if(key == 13)  // the enter key code
            {
                e.preventDefault()
                if(escapeHTML($("#mesaj").val())==""){
                    toastr.warning("<?= langS(270,2) ?>");
                }else{
                    $.ajax({
                        url:"<?= base_url() ?>message-send-adverts",
                        type: 'POST',
                        data: {type:2,token:"<?= $uniq->sipNo ?>",mesaj:escapeHTML($("#mesaj").val()),lang:"<?= $_SESSION["lang"] ?>"},
                        success: function (response) {
                            if(response.hata=="var"){
                                toastr.warning(response.message);
                                $("#mesaj").val("");
                            }else{
                                toastr.success(response.message);
                                $("#mesaj").val("");
                                messageLoad();

                            }


                        },
                    });
                }


            }else{

            }

        });

        $("#sendMesaj").on("click",function (e){

            e.preventDefault()
            $("#sendMesaj").prop("disabled",true);
            if(escapeHTML($("#mesaj").val())==""){
                toastr.warning("<?= langS(270,2) ?>");
                $("#sendMesaj").prop("disabled",false);

            }else{
                $.ajax({
                    url:"<?= base_url() ?>message-send-adverts",
                    type: 'POST',
                    data: {token:"<?= $uniq->sipNo ?>",mesaj:escapeHTML($("#mesaj").val()),type:2,lang:"<?= $_SESSION["lang"] ?>"},
                    success: function (response) {
                        if(response.hata=="var"){
                            $("#sendMesaj").prop("disabled",false);

                            toastr.warning(response.message);
                            $("#mesaj").val("");
                        }else{
                            $("#sendMesaj").prop("disabled",false);
                            messageLoad();

                            toastr.success(response.message);
                            $("#mesaj").val("");
                        }
                    },
                });
            }
        })

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
                    url: "<?= base_url("add-create-request?t=1") ?>",
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

    });
</script>