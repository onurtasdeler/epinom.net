<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    var countdownInterval;
    var countdownIntervalSaniye;
    var tarih;
    function geriSayim(){
        countdownInterval = setInterval(function() {
                $.ajax({
                    url: "<?= base_url("set-profil-callback") ?>",
                    type: 'POST',
                    data: {},
                    success: function (response) {
                        if(!response.veri){
                            window.location.reload();
                        }else{
                            $('#countdown').text("<?= langS(167,2) ?>: " + response.minutes + " <?= ($_SESSION["lang"]==1)?" dakika":" minute" ?> " + response.seconds + " <?= ($_SESSION["lang"]==1)?" saniye":" seconds" ?>");
                        }
                    },
                    cache: false,
                });
        }, 1000);
    }
    $(document).ready(function (){
        $("#tcVerifyForm").validate({
            rules: {
                tcNo: {
                    required:true,
                    minlength: 11,
                    maxlength: 11,
                },
                dateBirth: {
                    required:true,
                    minlength: 4,
                    maxlength: 4,
                }
            },
            messages: {
                dateBirth: {

                },
                tcNo: {

                },
            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("tcVerifyForm"));
                $("#submitButtons").prop("disabled",true);
                $("#submitButtons").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");
                $.ajax({
                    url: "<?= base_url("set-profil-verificate") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if(response){
                            if(response.hata=="var"){
                                if(response.type=="validation"){
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    $("#submitButtons").prop("disabled",false);
                                    $("#submitButtons").html("<i class='fa fa-check'></i> <?= langS(159,2) ?>");
                                }else{
                                    toastr.warning(response.message);
                                    $("#uyCont .alert").removeClass("alert-success").addClass("alert-warning");
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(200);
                                    $("#submitButtons").prop("disabled",false);
                                    $("#submitButtons").html("<i class='fa fa-check'></i> <?= langS(159,2) ?>");
                                }
                            }else{
                                $(".deleted").remove();
                                $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(500);
                                toastr.success(response.message);
                                $("#submitButtons").prop("disabled",false);
                                $("#submitButtons").html("<i class='fa fa-check'></i> <?= langS(159,2) ?>");
                                setTimeout(function (){
                                    window.location.reload();
                                },1200);
                            }
                        }else{
                            toastr.warning("Ağınızda beklenmedik bir hata meydana geldi. Lütfen tekrar deneyiniz");
                            $("#submitButton").prop("disabled",false);
                            $("#submitButton").html("<i class='fa fa-check'></i> <?= $kayitt->titleh1 ?>");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        });
        var typesSub=1;
        <?php
        if($_SESSION["telVerifyToken"]){
            ?>
            typesSub=2;
            geriSayim();
            <?php
        }
        ?>


        $('#tc').bind('paste copy cut', function(){return false;})
        $('#dyil').bind('paste copy cut', function(){return false;})
        $('#tel').bind('paste copy cut', function(){return false;})
        $('.verification-email').click(function(e){
            $('.verification-email-popup').fadeIn(300);
            e.preventDefault();
        })
        $('.verification-email-popup .cls').click(function(){
            $(this).parent().parent().fadeOut(300);
        })

        $('.numberonly').keypress(function (e) {
            var charCode = (e.which) ? e.which : event.keyCode
            if (String.fromCharCode(charCode).match(/[^0-9]/g))
                return false;
        });

        $("#emailSend").on("click",function (){
            $("#emailSend").attr("disabled","disabled");
            $("#emailSend span").hide();
            $("#wait").fadeIn(100);
            if($("#email").val()){
                $.ajax({
                    url:"<?= base_url() ?>user-verification",
                    type: 'POST',
                    data: {lang:<?= $_SESSION["lang"] ?>,types:"email",email:$("#email").val(),typesSub:1},
                    success: function (response) {
                        if(response.err=="aktif"){
                            toastr.warning(response.message);
                        }else if(response.err=="ok"){
                            $("#emailSend").hide();
                            $("#emailSendCode").show();
                            $("#emailBilgi").fadeIn(200);
                            $("#email").fadeOut(100);
                            $("#emailKod").fadeIn(200);
                        }else if(response.err="emailFail"){
                            window.location.reload();
                        }
                    },
                });
            }else{
                toastr.warning("<?= langS(164,2) ?>");
            }

        });
        $("#telSend").on("click",function (){
            $("#telSend").prop("disabled",true);
            $("#telSend span").hide();
            $("#waittel").fadeIn(100);
            if(typesSub==2){
                if($("#telKod").val() && $("#telKod").val().length==6){
                    $.ajax({
                        url:"<?= base_url() ?>set-profil-verificate",
                        type: 'POST',
                        data: {lang:<?= $_SESSION["lang"] ?>,type:"tel",tel:$("#tel").val(),typesSub:typesSub,code:$("#telKod").val()},
                        success: function (response) {
                            if(response.hata=="var"){
                                toastr.warning(response.message);
                                $("#telSend").prop("disabled",false);
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(400);
                            }else{
                                toastr.success(response.message);
                                $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success").html(response.message);
                                $("#uyCont").fadeIn(400);
                                $("#kods").fadeOut(200);
                                setTimeout(function (){
                                    window.location.reload();
                                },1200);
                            }
                        },
                    });
                }else{
                    $("#telSend").prop("disabled",false);
                    toastr.warning("<?= ($_SESSION["lang"]==1)?"Kontrol Et":"Check it" ?>");
                }
            }else{
                if($("#tel").val()){
                    $.ajax({
                        url:"<?= base_url() ?>set-profil-verificate",
                        type: 'POST',
                        data: {lang:<?= $_SESSION["lang"] ?>,type:"tel",tel:$("#tel").val(),typesSub:typesSub},
                        success: function (response) {
                            if(response.hata=="var"){
                                toastr.warning(response.message);
                                $("#telSend").prop("disabled",false);
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(400);
                            }else{
                                $("#kods").fadeIn(400);
                                $("#telContainer").hide();
                                $("#telKod").fadeIn(400);
                                $("#telSend").prop("disabled",false);
                                typesSub=2;
                                geriSayim();
                                $("#telContainerLabel").hide();
                            }
                        },
                    });
                }else{
                    $("#telSend").removeAttr("disabled");
                    $("#telSend").show();
                    toastr.warning("<?= ($_SESSION["lang"]==1)?"Kontrol Et":"Check it" ?>");
                }
            }


        });





        $("#emailSendCode").on("click",function (){
            if($("#emailKod").val()){
                $.ajax({
                    url:"<?= base_url() ?>user-verification",
                    type: 'POST',
                    data: {lang:<?= $_SESSION["lang"] ?>,code:$("#emailKod").val(),types:"email",typesSub:2},
                    success: function (response) {
                        if(response.err=="fail"){
                            toastr.warning(response.message);
                        }else if(response.err=="ok"){
                            toastr.success(response.message);
                            $(".verification-email").hide();
                            $("#emailSuccessVerify").html(response.messageP);
                            $("#emailSuccessVerify").show();
                            $("#emailBox").css("border","1px solid #7bd757");
                            $("#emailVerifyIcon").fadeIn(200);
                            $('.verification-email-popup .cls').parent().parent().fadeOut(500);

                        }
                    },
                });
            }else{
                toastr.warning("<?= langS(164,2) ?>");
            }

        });

        $("#telSendCode").on("click",function (){
            if($("#telKod").val()){
                $.ajax({
                    url:"<?= base_url() ?>user-verification",
                    type: 'POST',
                    data: {lang:<?= $_SESSION["lang"] ?>,code:$("#telKod").val(),types:"tel",typesSub:2},
                    success: function (response) {
                        if(response.err=="fail"){
                            toastr.warning(response.message);
                        }else if(response.err=="ok"){
                            toastr.success(response.message);
                            $(".verification-tel").hide();
                            $("#telSuccessVerify").html(response.messageP);
                            $("#telSuccessVerify").show();
                            $("#telBox").css("border","1px solid #7bd757");
                            $("#telVerifyIcon").fadeIn(200);
                            $('.verification-tel-popup .cls').parent().parent().fadeOut(500);

                        }
                    },
                });
            }else{
                toastr.warning("<?= langS(164,2) ?>");
            }

        });

        $("#tcOnay").on("click",function (){
            if($("#tc").val() && $("#dyil").val() && $("#ad").val() && $("#soyad").val()){
                $("#tcOnay span").hide();
                $("#tcOnay").attr("disabled","disabled");
                $("#waittc").fadeIn(100);
                $.ajax({
                    url:"<?= base_url() ?>user-verification",
                    type: 'POST',
                    data: {lang:<?= $_SESSION["lang"] ?>,tc:$("#tc").val(),name:$("#ad").val(),surname:$("#soyad").val(),birth:$("#dyil").val(),types:"tc"},
                    success: function (response) {
                        if(response.err=="ok"){
                            $(".verification-tc").hide();
                            $("#tcSuccessVerify").html(response.messageP);
                            $("#tcBox").css("border","1px solid #7bd757");
                            $("#tcSuccessVerify").show();
                            $("#tcVerifyIcon").fadeIn(100);
                            $("#bilgitc").hide();
                            $(".verification-tc-popup .cls").parent().parent().fadeOut(500);

                            toastr.success(response.message);
                        }else{
                            toastr.warning(response.message);
                            $("#tcOnay span").show();
                            $("#tcOnay").removeAttr("disabled");
                            $("#waittc").hide(100);
                        }
                    },
                });
            }else{
                if($("#ad").val()==""){
                    $("#ad").css("border","1px solid #c72e3e");
                }else{
                    $("#ad").css("border","none");
                }
                if($("#soyad").val()==""){
                    $("#soyad").css("border","1px solid #c72e3e");
                }else{
                    $("#soyad").css("border","none");
                }
                if($("#tc").val()==""){
                    $("#tc").css("border","1px solid #c72e3e");
                }else{
                    $("#tc").css("border","none");
                }
                if($("#dyil").val()==""){
                    $("#dyil").css("border","1px solid #c72e3e");
                }else{
                    $("#dyil").css("border","none");
                }

                toastr.warning("<?= langS(171,2) ?>");
            }
            tcVerifyForm
        });

    });
</script>