<?php
$giris=getLangValue(25,"table_pages");
?>
<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $(document).ready(function () {

        $("#loginForm").on("submit",function (e){
            e.preventDefault();
            $("#submt").prop("disabled",true);
            $("#submt").html("<i style='    position: absolute;z-index: 1;left: 13px;top: 27%;-webkit-transform: translateY(-50%);-ms-transform: translateY(-50%);transform: translateY(-50%);' class='fa fa-spinner fa-spin'></i> <?= langS(347,2) ?>");
            var formData = new FormData(this);
            $.ajax({
                url:"<?= base_url() ?>user-login",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response.type){
                        if(response.err){
                            if(response.type=="validation"){
                                var result = $(response.message).text().split('\n');
                                for(var i=0;i<result.length;i++){
                                    toastr.warning(result[i]);
                                }
                                $("#submt").prop("disabled",false);
                                $("#submt").html("<?= langS(484,2) ?>");
                            }else if(response.type=="mail"){
                                $("#submt").prop("disabled",false);
                                $("#submt").html("<?= langS(484,2) ?>");
                                toastr.warning("<?= langS(171,2) ?>")
                            }else if(response.type=="mail2"){
                                $("#submt").prop("disabled",false);
                                $("#submt").html("<?= langS(484,2) ?>");
                                toastr.warning("Mail gönderilirken hata meydana geldi.");
                            }
                        }else{
                            if(response.type=="mailok"){
                                $(".changecont").hide();
                                $(".kodsCont").show();
                                $(".passcont").fadeIn(600);
                                $("#contrs").val("r12r");
                                $("#submt").prop("disabled",false);
                                $("#submt").html("<?= langS(486,2) ?>");
                                toastr.success("<?= langS(485,2) ?>");
                            }
                        }

                    }else{
                        if(response.type2){
                            if(response.err){
                                if(response.type2=="validation"){
                                    var result = $(response.message).text().split('\n');
                                    for(var i=0;i<result.length;i++){
                                        toastr.warning(result[i]);
                                    }
                                    $("#submt").prop("disabled",false);
                                    $("#submt").html("<?= langS(484,2) ?>");
                                }else if(response.type2=="mail"){
                                    $("#submt").prop("disabled",false);
                                    $("#submt").html("<?= langS(484,2) ?>");
                                    toastr.warning("<?= langS(171,2) ?>")
                                }else if(response.type=="mail2"){
                                    $("#submt").prop("disabled",false);
                                    $("#submt").html("<?= langS(484,2) ?>");
                                    toastr.warning("Mail gönderilirken hata meydana geldi.");
                                }
                            }else{
                                if(response.type2=="codeok"){
                                    $(".changecont").hide();
                                    $(".kodsCont").hide();
                                    $(".kodsContPass").fadeIn(600);
                                    $("#contrs").val("r12rel");
                                    $("#submt").prop("disabled",false);
                                    $("#submt").html("<?= langS(487,2) ?>");
                                    toastr.success("<?= langS(488,2) ?>");
                                }
                            }
                        }else if(response.type3){
                            if(response.err){
                                if(response.type3=="validation"){
                                    var result = $(response.message).text().split('\n');
                                    for(var i=0;i<result.length;i++){
                                        toastr.warning(result[i]);
                                    }
                                    $("#submt").prop("disabled",false);
                                    $("#submt").html("<?= langS(484,2) ?>");
                                }else if(response.type3=="mail"){
                                    $("#submt").prop("disabled",false);
                                    $("#submt").html("<?= langS(484,2) ?>");
                                    toastr.warning("<?= langS(171,2) ?>")
                                }else if(response.type=="mail2"){
                                    $("#submt").prop("disabled",false);
                                    $("#submt").html("<?= langS(484,2) ?>");
                                    toastr.warning("Mail gönderilirken hata meydana geldi.");
                                }
                            }else{
                                if(response.type3=="passok"){

                                    $(".changecont").hide();
                                    $(".kodsCont").hide();
                                    $(".kodsContPass").hide();
                                    $(".logincont").fadeIn(600);
                                    $("#contrs").val("1");
                                    $("#submt").prop("disabled",true);
                                    $("#submt").html("<?= langS(22,2) ?>");
                                    toastr.success("<?= langS(489,2) ?>");
                                    setTimeout(function (){
                                        window.location.reload();
                                    },1200);
                                }
                            }
                        }else{
                            if(response.errorr=="yok"){
                                toastr.success("<?= str_replace("\r\n","",langS(219,2)) ?>");
                                setTimeout(function(){ window.location.href="<?= base_url(gg()) ?>" }, 2000);
                            }else if(response.errorr=="banned"){
                                toastr.error(response.message);
                                $("#submt").prop("disabled",false);
                                $("#submt").html("<?= langS(22,2) ?>");
                            }else if(response.errorr=="oturum"){
                                toastr.error(response.message);
                                $("#submt").prop("disabled",false);
                                $("#submt").html("<?= langS(22,2) ?>");
                            }else{
                                var result = $(response.message).text().split('\n');
                                for(var i=0;i<result.length;i++){
                                    toastr.warning(result[i]);
                                }
                                $("#submt").prop("disabled",false);
                                $("#submt").html("<?= langS(22,2) ?>");
                            }
                        }
                    }

                },
                cache: false,
                contentType: false,
                processData: false
            });
        });
        var typess=1;
        $("#changePasswordLink").submit(function () {
            if ($("#email").val()) {
                $("#submt").prop("disabled",true);
                $("#submt").html("<i style='position: absolute;z-index: 1;left: 13px;top: 27%;-webkit-transform: translateY(-50%);-ms-transform: translateY(-50%);transform: translateY(-50%);' class='fa fa-spinner fa-spin'></i> <?= langS(347,2) ?>");

                $.ajax({
                    url:"<?= base_url() ?>user-change-password",
                    type: 'POST',
                    data: {email:$("#email").val(),kod:$("#kod").val(),pass:$("#pass").val(),passtry:$("#passtry").val(),type:typess},
                    success: function (response) {
                        if(response.hata=="var"){
                            if(response.step=="mail"){
                                toastr.warning(response.message);
                                $("#submt").prop("disabled",false);
                                $("#submt").html("<?= langS(486,2) ?>");
                                typess=2;
                            }else if(response.step=="pass"){
                                toastr.warning(response.message);
                                $("#submt").prop("disabled",false);
                                $("#submt").html("<?= langS(487,2) ?>");
                                typess=3;
                            }
                        }else{
                            if(response.step){
                                if(response.step=="mail"){
                                    $("#emailCont").fadeOut(200);
                                    $(".kodes").fadeIn(700);
                                    $("#submt").prop("disabled",false);
                                    $("#submt").html("<?= langS(486,2) ?>");
                                    typess=2;
                                }else if(response.step=="pass"){
                                    $(".kodes").fadeOut(200);
                                    $(".pass").fadeIn(700);
                                    $("#submt").prop("disabled",false);
                                    $("#submt").html("<?= langS(487,2) ?>");
                                    typess=3;
                                }else if(response.step=="finish"){
                                    $(".kodes").remove();
                                    $(".pass").remove();
                                    $("#submt").remove();
                                    $("#uyari #uyariAlert").addClass("alert-success").html("<?= langS(489,2) ?>");
                                    $("#uyari").fadeIn(600);
                                    setTimeout(function (){
                                        window.location.href="<?= base_url(gg().$giris->link) ?>";
                                    },1200);
                                    typess=4;
                                }
                            }
                        }
                    },
                });
            } else{
                toastr.warning("<?= langS(171,2) ?>");
            }
        });
    });

    

    $(function(){
        $("#changePassword").on("click",function (){
            if($("#email").val()){

            }
        });

        
        $("#sifreGuncelle").on("click",function (){
            if($("#contrs").val()){
                if($("#contrs").val()==1){
                    $(".changecont").hide();
                    $(".kodsCont").hide();
                    $(".kodsContPass").hide();
                    $(".logincont").fadeIn(400);
                    $("#sifreGuncelle").text("<?= langS(481,2) ?>");
                    $("#baslik").html("<?= langS(22,2) ?>");
                    $("#aciklama").html("<?= langS(23,2) ?>");
                    $("#submt").html("<?= langS(22,2) ?>");
                    $("#contrs").val("2");
                }else{
                    $(".logincont").hide();
                    $(".changecont").fadeIn(400);
                    $("#sifreGuncelle").text("Giriş Yap");
                    $("#baslik").html("<?= langS(482,2) ?>");
                    $("#aciklama").html("<?= langS(483,2) ?>");
                    $("#submt").html("<?= langS(484,2) ?>");
                    $("#contrs").val("1");
                }
            }else{
                $(".logincont").hide();
                $(".changecont").fadeIn(400);
                $("#sifreGuncelle").text("Giriş Yap");
                $("#baslik").html("<?= langS(482,2) ?>");
                $("#aciklama").html("<?= langS(483,2) ?>");
                $("#submt").html("<?= langS(484,2) ?>");
                $("#loginForm").append("<input type='hidden' id='contrs' name='sifreguncs' value='1'>");
            }

        });

        $('.onlyTxt').keypress(function (e) {
            var regex = /^[a-züöçğşıİÜĞÇŞÖ\s]+$/i;
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else
            {
                e.preventDefault();
                return false;
            }
        });
        $("#name").bind("cut copy paste", function(){
            return false;
        });
        $("#phone").bind("cut copy paste", function(){
            return false;
        });
        $("#email").bind("cut copy paste", function(){
            return false;
        });
    });


</script>