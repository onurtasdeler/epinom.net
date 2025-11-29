
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    <?php $user=getActiveUsers();
    $mesajlar=getLangValue(38,"table_pages");

    ?>


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
    

    function messageLoad(d=0){
        $.ajax({
            url:"<?= base_url() ?>message-load",
            type: 'POST',
            data: {user:"<?= $user->token ?>",talep:"<?= $uniq->islemNo ?>",lang:"<?= $_SESSION["lang"] ?>"},
            success: function (response) {
                if(response){
                    $("#scrollss").html(response.str);
                    $("#scrollss").scrollTop(10000000);
                }
            },
        });


    }



    $(document).ready(function (){

        setInterval(function (){
            messageLoad();

        },10000);

        $("#scrollss").scrollTop(10000);

        $("#searchOne").on('input propertychange paste', function () {
            var value = $("#searchOne").val();
            // eğer input içinde değer yoksa yani boşsa tüm menüyü çıkartıyoruz
            if (value.length == 0) {
                $(" .clearfix").fadeIn(100);
                // arama yapılmışsa ilk olarak tüm menüyü gizliyoruz ve girilen değer ile eşleşen kısmı çıkarıyoruz
            } else {
                $(".list-unstyled .clearfix").fadeOut(100);
                $(".list-unstyled .clearfix:contains(" + value + ")").fadeIn(100);
            }
        });

        /*var body = $("html, body");
            body.stop().animate({scrollTop:330}, 300, 'swing', function() {
        });*/


        messageLoad();

        $('#mesaj').keypress(function (e) {

                var key = e.which;
                if(key == 13)  // the enter key code
                {
                    e.preventDefault()
                    if(escapeHTML($("#mesaj").val())==""){
                        toastr.warning("<?= langS(270,2) ?>");
                    }else{
                        $.ajax({
                            url:"<?= base_url() ?>send-message-post",
                            type: 'POST',
                            data: {user:"<?= $user->token ?>",talep:"<?= $uniq->islemNo ?>",mesaj:escapeHTML($("#mesaj").val()),lang:"<?= $_SESSION["lang"] ?>"},
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
                    url: "<?= base_url("add-create-request") ?>",
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





        $("#sendMesaj").on("click",function (e){

            e.preventDefault()
            $("#sendMesaj").prop("disabled",true);
            if(escapeHTML($("#mesaj").val())==""){
                toastr.warning("<?= langS(270,2) ?>");
                $("#sendMesaj").prop("disabled",false);

            }else{
                $.ajax({
                    url:"<?= base_url() ?>send-message-post",
                    type: 'POST',
                    data: {user:"<?= $user->token ?>",talep:"<?= $uniq->islemNo ?>",mesaj:escapeHTML($("#mesaj").val()),lang:"<?= $_SESSION["lang"] ?>"},
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


    });
</script>