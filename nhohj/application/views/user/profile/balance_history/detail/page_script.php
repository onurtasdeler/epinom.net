<script>

    <?php $user=getActiveUsers();
    $giris=getLangValue(24);
    ?>
    function messageLoad(d=0){
        if($("#talep").val()){
            $.ajax({
                url:"<?= base_url() ?>add-talep-message",
                type: 'POST',
                data: {user:"<?= $user->token ?>",types:2,talep:$("#talep").val()},
                success: function (response) {
                    if(response){
                        $("#sohbetIcerik").html(response.veri);
                        $(".chat-history").scrollTop($(".chat-history").height()+10000000);

                    }
                },
            });
        }

    }

    $(document).ready(function (){
        messageLoad();
        setInterval(function () {
            messageLoad();
        }, 10000);

        $("#sendMesaj").on("click",function (e){
            e.preventDefault()
            if($("#mesaj").val()=="" || $("#talep").val()==""){
                toastr.warning("<?= langS(171,2) ?>");
            }else{
                $.ajax({
                    url:"<?= base_url() ?>add-talep-message",
                    type: 'POST',
                    data: {user:"<?= $user->token ?>",talep:$("#talep").val(),mesaj:$("#mesaj").val()},
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
                                if(response.status==2){
                                    //$("#mesajVal").remove();
                                }
                               toastr.success(response.message);
                                $("#mesaj").val("");
                                messageLoad();
                            }
                        }else{
                            toastr.warning("<?= langS(38,2) ?>");
                        }
                    },
                });
            }
        })

    });
</script>