<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>

    <?php $user=getActiveUsers();
    $giris=getLangValue(24);
    ?>

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