<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

    <?php $user=getActiveUsers();
    $giris=getLangValue(24);
    ?>

    function messageLoad(d=0){
        $.ajax({
            url:"<?= base_url() ?>message-load-adverts",
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
        messageLoad();
        setInterval(function () {
            messageLoad();
        }, 10000);

        $(".teslimatButton").on("click",function (){
            if($(this).data("rid")){
                $(this).hide();
                $(".teslimatButtonLoader").show();
                $.ajax({
                    url:"<?= base_url() ?>order-teslimat",
                    type: 'POST',
                    data: {adNo:$(this).data("rid"),types:1},
                    success: function (response) {
                        if(response){
                            if(response.err){
                                if(response.message=="oturum"){
                                    window.location.href="<?= base_url("logout") ?>";
                                }else if(response.message=="var"){
                                    //talepvarsa
                                }else{
                                    toastr.warning(response.message);
                                    $("#mesaj").val("");
                                }
                            }else{
                                $("#tFirst").fadeOut(600);
                                setTimeout(function (){
                                    $("#alici").addClass("active");
                                    $("#tFirst").html( response.name + " Adlı İlanı <b>" + response.date + "</b> tarihinde teslim etme isteğiniz alınmıştır.");
                                    $(".sss").append('<span id="tTwo" style="margin-top:30px; width:90%; color:#393939; background: #e3e0ceb8; display:none ">' +
                                        '<i class="mdi mdi-message"></i> Canlı Sohbet üzerinden alıcı ile görüşebilirsiniz. <br>' +
                                        'Sohbet esnasında <b>sohbet kurallarına uymayı unutmayınız.</b><br>' +
                                        '<a href="#ch" class="sohbetButton" > ' +
                                        '<i class="mdi mdi-check" style="font-size:13px;"></i>Canlı Sohbete Git</a></span>');
                                    $(".sss").append('<span id="tThree" style="margin-top:30px; width:90%; color:#393939; background: #f7e24cb8; display:none"><b>' +
                                          '<i class="mdi mdi-clock"></i> ' + response.alici + '</b> adlı alıcının onayı beklenmektedir.<br></span>');
                                    $(".sss #tFirst").fadeIn(300);
                                    $(".sss #tTwo").fadeIn(600);
                                    $(".sss #tThree").fadeIn(900);
                                    $("#chats").fadeIn(600);
                                    $("#ch").fadeIn(600);
                                    $("#chatCont").fadeIn(600);
                                },700);


                            }
                        }else{
                            toastr.warning("<?= langS(38,2) ?>");
                        }
                    },
                });
            }else{
                window.location.href="<?= base_url("logout") ?>";
            }
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
                        data: {type:1,token:"<?= $uniq->sipNo ?>",mesaj:escapeHTML($("#mesaj").val()),lang:"<?= $_SESSION["lang"] ?>"},
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
        $("#kanitYukle").on("click",function (e) {
            e.preventDefault();
            $("#kanitYukle").prop("disabled",true);
            var fileInput = $("#kanit_video")[0];
            if(fileInput.files.length > 0) {
                const formData = new FormData();
                const file = fileInput.files[0];
                formData.append("file",file);
                formData.append("sipNo","<?= $uniq->sipNo ?>");
                $.ajax({
                    url: "<?= base_url() ?>upload-video-proof", // Sunucu URL'si
                    type: "POST",
                    data: formData,
                    contentType: false, // FormData için gerekli
                    processData: false, // FormData için gerekli
                    success: function (response) {
                        if(response && response.hata == "yok") {
                            toastr.success("Dosya başarıyla yüklendi!");
                            location.reload();
                        } else {
                            toastr.warning("Dosya yüklenirken hata oluştu!");
                        }
                    },
                    error: function () {
                        toastr.warning("Dosya yüklenirken hata oluştu!");
                    }
                }).done(()=>{
                    $("#kanitYukle").prop("disabled",true);
                });
            } else {
                toastr.warning("Dosya seçmediniz.");
                $("#kanitYukle").prop("disabled",false);
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
                    data: {token:"<?= $uniq->sipNo ?>",mesaj:escapeHTML($("#mesaj").val()),type:1,lang:"<?= $_SESSION["lang"] ?>"},
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