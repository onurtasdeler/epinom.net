<script>

    <?php $user=getActiveUsers();
    $giris=getLangValue(24);
    ?>
    function getListMyAds(page,types,ad="",orders=""){
        $("#waitLoad").show();
        $("#ilanYukle").hide();
        $("#sayfaLa").hide();
        $.ajax({
            url:"<?= base_url() ?>get-list-my-balance",
            type: 'POST',
            data: {user:"<?= $user->token ?>",types:types,page:$("#page").val(),ad:ad,orders:orders,lang:<?= $_SESSION["lang"] ?>},
            success: function (response) {
                if(page==0){
                    if(response.veriler){
                        $("#waitingSearchAds").show();
                        $("#sayfaLa").html(response.sayfalama);
                        $("#ilanYukle").html(response.veriler);
                        $("#sayfaLa").before(response.sayfalama);
                        $("#sayfaLa #sayfalamaCont").fadeIn(400);
                        $("#page").val(response.page);
                        $("#waitLoad").fadeOut(400);
                        setTimeout(function() {$("#ilanYukle").fadeIn(300);
                            $("#sayfaLa").fadeIn(300);}, 600);
                    }else{
                        $("#waitingSearchAds").hide();
                        $("#sayfaLa").hide();
                        //$("#ilanYukle").hide();
                        $("#ilanYukle").html('<div class="alert alert-secondary" role="alert"><?= langS(270,2,$_SESSION["lang"]) ?></div>');
                        $("#waitLoad").fadeOut(400);
                        setTimeout(function() {$("#ilanYukle").fadeIn(300);}, 600);

                    }
                }else{
                    if(response.veriler){
                        $("#sayfaLa").html(response.sayfalama);
                        $("#sayfaLa").parent(".box").remove();
                        $("#ilanYukle").html(response.veriler);
                        $("#sayfaLa").before(response.sayfalama);
                        $("#sayfaLa #sayfalamaCont").fadeIn(400);
                        $("#page").val(response.page);
                        $("#waitLoad").fadeOut(400);
                        setTimeout(function() {$("#ilanYukle").fadeIn(300);
                            $("#sayfaLa").fadeIn(300);}, 600);
                        var body = $("html, body");
                        body.stop().animate({scrollTop:550}, 200, 'swing', function() {
                        });
                    }else{
                        //$("#waitingSearchAds").hide();
                        $("#sayfaLa").hide();
                        $("#ilanYukle").html('<div class="alert alert-secondary" role="alert"><?= langS(270,2,$_SESSION["lang"]) ?></div>');
                        $("#waitLoad").fadeOut(400);
                        setTimeout(function() {$("#ilanYukle").fadeIn(300);}, 600);
                    }

                }

            },
        });
    }
    function copyToClipboard(kod) {
        navigator.clipboard.writeText(kod);
        toastr.success("<?=  langS(253,2) ?>")
    }



    $(document).ready(function (){
        getListMyAds(0,1);

        var body = $("html, body");
        body.stop().animate({scrollTop:330}, 300, 'swing', function() {
        });

        $("#sayfaLa").on("click",".filterPage",function (){
            $("#page").val($(this).data("id"));
            getListMyAds(1,1,$("#waitingSearchAds").val());
            var body = $("html, body");
            body.stop().animate({scrollTop:550}, 200, 'swing', function() {
            });
        });
        //bekleyen siparişler arama
        $("#waitingSearchAds").on("input paste",function (){
            $("#page").val(0);
            if($(this).val()){
                getListMyAds(1,1,$(this).val(),$("#waitingFilterOrder").val());
            }else{
                getListMyAds(0,1);
            }
        });

    });
</script>