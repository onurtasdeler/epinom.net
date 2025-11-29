<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<?php
$giris = getLangValue(25);
$profil = getLangValue(31);
?>


<script>


    var pageDop="-1";
    var limitDop="24";
    var order="latest";

    var pageNormal="-1";
    var limitNormal="24";
    var ordernormal="latest";

    var formsData="";
    <?php
    if($altaltkategori!="a"  && $altkategori!="a"){
        ?>
        var typesCat=3;
        var catTop="<?= $altaltkategori ?>";
        var catSub="<?= $uniq->id ?>";
        var catMain="<?= $uniq->top_id ?>";

        <?php
    }else if($altaltkategori=="a"  && $altkategori!="a"){
        ?>
        var typesCat=2;
        var catTop="<?= $uniq->id ?>";
        var catSub=0;
        var catMain="<?= $uniq->top_id ?>";
    <?php
    }else{
        ?>
        var typesCat=2;
        var catTop=0;
        var catSub=0;
        var catMain="<?= $uniq->id ?>";
        <?php
    }
    ?>


    //types 1: doping ads
    //types 2: normal ads
    function getListAds(main="a",top="a",sub="a",page,types,limit,typeCat,orders="",ordersnormal="",filter=""){

        $.ajax({
            url:"<?= base_url() ?>get-list-category",
            type: 'POST',
            data: {types:types,main:main,top:top,sub:sub,page:page,pageNormal:pageNormal,limit:limit,typecat:typeCat,order:order,ordernormal:ordernormal,filters:formsData,ids:ids,idsNormal:idsNormal},
            success: function (response) {
                if(types==1){
                    //doping
                    if(response.veri!="nothing"){

                        if(filter!=""){
                            pageDop=response.page;
                        }else{
                            if(orders!=""){
                                pageDop=response.page;
                            }else{
                                pageDop=response.page;
                            }
                        }

                        if(response.lasts!=""){
                            if(types==1){
                                $("#loadMoreDop").show();
                            }

                            if(response.ids){
                                ids=response.ids;
                            }

                            if(filter!=""){
                                $("#loadResultDop").hide();
                                $("#loaderDops").fadeIn(200);
                                $("#loadMoreDop").hide();

                                setTimeout(function (){
                                    $("#loadMoreDop").show();
                                    $("#loaderDops").fadeOut(200);
                                    $("#loadResultDop").html(response.veri);
                                },500)

                            }else{

                                if(orders){
                                    $("#loaderDops").fadeIn(200);
                                    $("#loadMoreDop").hide();

                                    setTimeout(function (){
                                        $("#loadMoreDop").show();
                                        $("#loaderDops").fadeOut(200);
                                        $("#loadResultDop").html(response.veri);
                                        $("#loadResultDop").fadeIn(300);
                                    },500)
                                }else{
                                    $("#loaderDops").fadeIn(200);
                                    $("#loadMoreDop").hide();
                                    setTimeout(function (){
                                        $("#loadMoreDop").show();

                                        $("#loaderDops").fadeOut(200);
                                        $("#loadResultDop").append(response.veri);
                                        $("#loadResultDop").fadeIn(300);
                                    },500)
                                }
                            }
                        }else{

                            if(types==1){
                                $("#loadMoreDop").hide();
                            }
                            if(filter!=""){

                                    $("#loadResultDop").html(response.veri);

                            }else{
                                if(orders){
                                    $("#loadResultDop").html(response.veri);
                                }else{
                                    $("#loadResultDop").append(response.veri);
                                }
                            }

                        }
                        var body = $("html, body");
                        body.stop().animate({scrollTop:200}, 400, 'swing', function() {});
                    }else{
                        toastr.warning("Kayıt Yok");
                        var body = $("html, body");
                        body.stop().animate({scrollTop:200}, 400, 'swing', function() {});
                    }
                }else{
                    if(response.veri!="nothing"){

                        if(filter!=""){
                            pageNormal=response.page;
                        }else{
                            if(order!=""){
                                pageNormal=response.page;
                            }else{
                                pageNormal=response.page;
                            }
                        }

                        if(response.lasts!=""){
                            if(types==2){
                                $("#loadMoreNormal").show();
                            }

                            if(response.ids){
                                idsNormal=response.ids;
                            }

                            if(filter!=""){
                                $("#loadResultNor").hide();
                                $("#loaderNors").fadeIn(200);
                                $("#loadMoreNormal").hide();

                                setTimeout(function (){
                                    $("#loadMoreNormal").show();
                                    $("#loaderNors").fadeOut(200);
                                    $("#loadResultNor").html(response.veri);
                                },500)

                            }else{

                                if(ordersnormal){
                                    $("#loaderNors").fadeIn(200);
                                    $("#loadMoreNormal").hide();

                                    setTimeout(function (){
                                        $("#loadMoreNormal").show();
                                        $("#loaderNors").fadeOut(200);
                                        $("#loadResultNor").html(response.veri);
                                        $("#loadResultNor").fadeIn(300);
                                    },500)
                                }else{
                                    $("#loaderNors").fadeIn(200);
                                    $("#loadMoreNormal").hide();
                                    setTimeout(function (){
                                        $("#loadMoreNormal").show();

                                        $("#loaderNors").fadeOut(200);
                                        $("#loadResultNor").append(response.veri);
                                        $("#loadResultNor").fadeIn(300);
                                    },500)
                                }
                            }
                        }else{

                            if(types==2){
                                $("#loadResultNor").hide();
                            }
                            if(filter!=""){
                                $("#loadResultNor").html(response.veri);
                            }else{
                                if(ordersnormal){
                                    $("#loadResultNor").html(response.veri);
                                }else{
                                    $("#loadResultNor").append(response.veri);
                                }
                            }

                        }

                        var body = $("html, body");
                        body.stop().animate({scrollTop:200}, 400, 'swing', function() {});

                    }else{
                        toastr.warning("Kayıt Yok");
                        var body = $("html, body");
                        body.stop().animate({scrollTop:200}, 400, 'swing', function() {});
                    }
                }
            },
        });
    }

    function getListAdsFilter(main="a",top="a",sub="a",page,types,limit,typeCat,orders="",ordersnormal="",filter="",){

        ids="";
        idsNormal="";
        $.ajax({
            url:"<?= base_url() ?>get-list-category-filter",
            type: 'POST',
            data: {types:types,main:main,top:top,sub:sub,page:page,pageNormal:pageNormal,limit:limit,typecat:typeCat,order:order,ordernormal:ordersnormal,filters:formsData,ids:ids,idsNormal:idsNormal},
            success: function (response) {
                if(response.hata){
                    toastr.warning(response.message);
                }else{
                    if(types==1){
                        //doping
                        if(response.veri!="nothing"){
                            if(filter!=""){
                                pageDop=response.page;
                            }else{
                                if(orders!=""){
                                    pageDop=response.page;
                                }else{
                                    pageDop=response.page;
                                }
                            }

                            if(response.lasts!=""){
                                if(types==1){
                                    $("#loadMoreDop").show();
                                }

                                if(response.ids){
                                    ids=response.ids;
                                }




                                if(filter!=""){
                                    $("#loadResultDop").fadeOut();
                                    $("#loaderDops").fadeIn(200);
                                    $("#loadMoreDop").hide();
                                    setTimeout(function (){
                                        $("#loadMoreDop").show();
                                        $("#loaderDops").fadeOut(200);
                                        $("#loadResultDop").html(response.veri);
                                        $("#loadResultDop").fadeIn(300);
                                    },500)
                                }else{
                                    if(orders){
                                        $("#loadResultDop").hide();
                                        $("#loaderDops").fadeIn(200);
                                        $("#loadMoreDop").hide();
                                        setTimeout(function (){
                                            $("#loadMoreDop").show();
                                            $("#loaderDops").fadeOut(200);
                                            $("#loadResultDop").html(response.veri);
                                            $("#loadResultDop").fadeIn(300);
                                        },500)

                                    }else {
                                        $("#loadResultDop").hide();
                                        $("#loaderDops").fadeIn(200);
                                        $("#loadMoreDop").hide();
                                        setTimeout(function () {
                                            $("#loadMoreDop").show();
                                            $("#loaderDops").fadeOut(200);
                                            $("#loadResultDop").append(response.veri);
                                            $("#loadResultDop").fadeIn(300);
                                        }, 500)
                                    }
                                }
                            }else{
                                if(types==1){
                                    $("#loadMoreDop").hide();
                                }
                                if(filter!=""){
                                    if(response.ids){
                                        ids=response.ids;
                                    }
                                    $("#loadResultDop").html(response.veri);
                                }else{
                                    if(orders){
                                        $("#loadResultDop").html(response.veri);
                                    }else{
                                        $("#loadResultDop").append(response.veri);
                                    }
                                }
                            }
                            var body = $("html, body");
                            body.stop().animate({scrollTop:200}, 400, 'swing', function() {});

                        }else{
                            toastr.warning("Kayıt Yok");
                            var body = $("html, body");
                            body.stop().animate({scrollTop:200}, 400, 'swing', function() {});
                        }
                    }
                    else{
                        if(response.veri!="nothing"){
                            if(filter!=""){
                                pageNormal=response.page;
                            }else{
                                if(ordersnormal!=""){
                                    pageNormal=response.page;
                                }else{
                                    pageNormal=response.page;
                                }
                            }

                            if(response.lasts!=""){
                                if(types==2){
                                    $("#loadMoreNormal").show();
                                }

                                if(response.ids){
                                    idsNormal=response.ids;
                                }

                                if(filter!=""){
                                    $("#loadResultNor").fadeOut();
                                    $("#loaderNors").fadeIn(200);
                                    $("#loadMoreNormal").hide();
                                    setTimeout(function (){
                                        $("#loadMoreNormal").show();
                                        $("#loaderNors").fadeOut(200);
                                        $("#loadResultNor").html(response.veri);
                                        $("#loadResultNor").fadeIn(300);
                                    },500)
                                }else{
                                    if(ordersnormal){
                                        $("#loadResultNor").hide();
                                        $("#loaderNors").fadeIn(200);
                                        $("#loadMoreNormal").hide();
                                        setTimeout(function (){
                                            $("#loadMoreNormal").show();
                                            $("#loaderNors").fadeOut(200);
                                            $("#loadResultNor").html(response.veri);
                                            $("#loadResultNor").fadeIn(300);
                                        },500)

                                    }else {
                                        $("#loadResultNor").hide();
                                        $("#loaderNors").fadeIn(200);
                                        $("#loadMoreNormal").hide();
                                        setTimeout(function () {
                                            $("#loadMoreNormal").show();
                                            $("#loaderNors").fadeOut(200);
                                            $("#loadResultNor").append(response.veri);
                                            $("#loadResultNor").fadeIn(300);
                                        }, 500)
                                    }
                                }
                            }else{
                                if(types==2){
                                    $("#loadMoreNormal").hide();
                                }
                                if(filter!=""){
                                    if(response.ids){
                                        idsNormal=response.ids;
                                    }
                                    $("#loadResultNor").html(response.veri);
                                }else{
                                    if(ordersnormal){
                                        $("#loadResultNor").html(response.veri);
                                    }else{
                                        $("#loadResultNor").append(response.veri);
                                    }
                                }
                            }
                            var body = $("html, body");
                            body.stop().animate({scrollTop:200}, 400, 'swing', function() {});

                        }else{
                            toastr.warning("Kayıt Yok");
                            var body = $("html, body");
                            body.stop().animate({scrollTop:200}, 400, 'swing', function() {});
                        }

                    }
                }

            },
        });
    }


    $(document).ready(function () {

        $("#speForm").on("submit",function (){
            formsData=$("#speForm").serialize();
            pageDop="-1";
            pageNormal="-1";
            getListAdsFilter(catMain,catTop,catSub,pageDop,1,limitDop,typesCat,"","",12);
            getListAdsFilter(catMain,catTop,catSub,pageNormal,2,limitNormal,typesCat,"","",12);
        });



        $("#loadMoreDop").on("click",function(){
            getListAds(catMain,catTop,catSub,pageDop,1,limitDop,typesCat);
        });

        $("#loadMoreNormal").on("click",function(){
            getListAds(catMain,catTop,catSub,pageNormal,2,limitNormal,typesCat);
        });


        $('#price_start').on("cut copy paste",function(e) {
            e.preventDefault();
        });
        $('#price_en').on("cut copy paste",function(e) {
            e.preventDefault();
        });


        $('#price_start').on("input change",function(e) {
            if (parseFloat($(this).val()) < 0) {
                // 0'dan küçükse değeri sıfırla
                $(this).val(0);
            }
        });
        $('#price_en').on("input change keyup",function(e) {
            if (parseFloat($(this).val()) < 0) {
                // 0'dan küçükse değeri sıfırla
                $(this).val(0);
            }
        });
       

        $(".dopOrder").on("click",function (){
            var deger=$(this).data("types").replace(/(<([^>]+)>)/ig,"");
            if(deger){
                order=deger;
                pageDop="-1";
                limitDop="24";
                ids="";
                $("#loadResultDop").hide();
                $("#loaderDops").fadeIn(200);
                $("#loadMoreDop").hide();
                getListAds(catMain,catTop,catSub,pageDop,1,limitDop,typesCat,order);
            }else{


            }
        });

        $(".NorOrder").on("click",function (){
            var deger=$(this).data("types").replace(/(<([^>]+)>)/ig,"");
            if(deger){
                ordernormal=deger;
                pageNormal="-1";
                limitNormal="24";
                idsNormal="";
                $("#loadResultNor").hide();
                $("#loaderNors").fadeIn(200);
                $("#loadMoreNormal").hide();
                getListAds(catMain,catTop,catSub,pageNormal,2,limitNormal,typesCat,order,ordernormal);
            }else{


            }
        });






    });

</script>
