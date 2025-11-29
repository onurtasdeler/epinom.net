
<?php //$this->cart->destroy()
$siparis=getLangValue(43,"table_pages");
// ?><script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        let befores="";
        let bReal="";
        $(".s").on("click",function (){
            var hash=$(this).data("hash");
            var quantity=parseInt($('.quantity[data-id="' + hash + '"]').val());
            if(quantity>0 && quantity<<?= getTableSingle("table_options",array("id" => 1))->default_max_sepet ?>){
                if($("#directBasket-" + hash)){
                    if($("#directBasket-" + hash).val()==2){
                        $.ajax({
                            url: '<?= base_url("add-basket-card") ?>',
                            method: 'POST',
                            data: {
                                hash:hash,
                                qty:quantity,
                            },
                            success: function (response) {
                                if(response){
                                    if(response.error){
                                        toastr.warning(response.message);
                                        $('.quantity[data-id="' + producthash + '"]').val(1);
                                        //$('.decrease-btn, .increase-btn').trigger("click");
                                    }else{
                                        toastr.success("<?= (lac()==1)?"Sepete Eklendi":"Added Basket" ?>");
                                    }

                                }
                            },
                            cache:false,
                        });
                    }
                }
            }else{
                $('.quantity[data-id="' + hash + '"]').val(1);
                tryControl(hash,1);
            }

        });
        $('.decrease-btn, .increase-btn').on('click', function () {
            var item=$(this);
            stopTimer();
            setTimeout(function (){
                item.prop("disabled",true);
                var producthash = item.data('id');
                var quantity = parseInt($('.quantity[data-id="' + producthash + '"]').val());

                var ty="";
                if (item.hasClass('increase-btn')) {
                    quantity++;
                    ty="plus";
                } else {
                    if (quantity > 1) {
                        quantity--;
                        ty="minus";
                    }else{
                        quantity=1;
                        ty="df";
                    }
                }


                $('.quantity[data-id="' + producthash + '"]').val(quantity);
                if(quantity==0){
                    tryControl(producthash,quantity);
                    $('.quantity[data-id="' + producthash + '"]').val(1);
                }else{
                    if(ty=="df"){
                        $('.quantity[data-id="' + producthash + '"]').val(1);
                    }else{
                        if(quantity>0 && quantity<<?= getTableSingle("table_options",array("id" => 1))->default_max_sepet ?>){
                            $.ajax({
                                url: '<?= base_url("add-basket-card") ?>',
                                method: 'POST',
                                data: {
                                    hash:producthash,
                                    qty:quantity,
                                    type:ty
                                },
                                success: function (response) {
                                    if(response){
                                        if(response.error){
                                            toastr.warning(response.message);
                                            if(quantity==1){
                                                $('.quantity[data-id="' + producthash + '"]').val(1);
                                            }else{
                                                $('.quantity[data-id="' + producthash + '"]').val(response.qty);
                                                tryControl(producthash,quantity,ty);
                                            }
                                            //$('.decrease-btn, .increase-btn').trigger("click");
                                        }else{
                                            if(response.message){
                                                toastr.warning(response.message);
                                            }
                                            if(response.total=="0.00 <?= getcur() ?>"){
                                                window.location.reload();
                                            }
                                            $("#totalBasket").html(response.total);
                                            if(response.price_dis){
                                                $("#priceMain-" + producthash).html(response.price);
                                                $("#priceMain1-" + producthash).html(response.price);
                                                $("#priceDis1-" + producthash + " del small").html(response.price_dis);
                                                $("#priceDis-" + producthash + " del small").html(response.price_dis);
                                                $('.quantity[data-id="' + producthash + '"]').val(response.qty);
                                            }else{
                                                $("#priceMain-" + producthash).html(response.price);
                                                $("#priceMain1-" + producthash).html(response.price);
                                                $('.quantity[data-id="' + producthash + '"]').val(response.qty);
                                            }
                                        }
                                    }
                                    item.prop("disabled",false);
                                    $('.decrease-btn, .increase-btn').prop("disabled",false);
                                },
                                cache:false,
                            });
                        }else{
                            $('.quantity[data-id="' + producthash + '"]').val(<?= getTableSingle("table_options",array("id" => 1))->default_max_sepet ?>);
                            tryControl(producthash,<?= getTableSingle("table_options",array("id" => 1))->default_max_sepet ?>,ty);
                        }
                    }
                }
            },250);
            startTimer();
        });
        $(".deleteBasket").on("click",function (){

            var deger=$(this).data("hash");
            if(deger){
                bReal=deger;
                $("#basketReal").val(deger);
            }else{
                bReal="";
                $("#basketReal").val("");
            }
        })

        $(".deleteReal").on("click",function (){
            if(bReal){
                $.ajax({
                    url: '<?= base_url("delete-basket-card") ?>',
                    method: 'POST',
                    data: {
                        hash:bReal,
                    },
                    success: function (response) {
                        if(response){
                            if(response.error){
                                toastr.warning(response.message);
                                bReal="";
                            }else{
                                bReal="";
                                toastr.success(response.message);
                                setTimeout(function (){
                                    window.location.reload();
                                },1200);
                            }

                        }
                    },
                    cache:false,
                });
            }else{
                window.location.reload();
            }
        });
        <?php
        if(getActiveUsers()){
            ?>
            $(".basketComplete").on("click",function (){

                $.ajax({
                    url: '<?= base_url("set-basket-complete") ?>',
                    method: 'POST',
                    data: {token:1},
                    success: function (response) {
                        if(response){
                            if(response.error){
                                if(response.type=="refresh"){
                                    toastr.warning(response.message);
                                    setTimeout(function (){
                                       window.location.reload();
                                    },1200);
                                }else{

                                }
                            }else{

                                $("#placebidModalx").modal("show");
                                $("#uyariMetin").html("<?= (lac()!=1)?'<br><i style=\"font-size:20px\" class=\"fa text-success fa-spinner fa-spin\"></i> <br> Please Wait. You are directed to the orders page':'<br><i style=\"font-size:20px\" class=\"fa text-success fa-spinner fa-spin\"></i> <br>Lütfen Bekleyiniz. Siparişlerim sayfasına yönlendiriliyorsunuz..' ?>");
                                setTimeout(function (){
                                    window.location.href="<?= base_url(gg().$siparis->link."?type=completed") ?>"
                                },2000)
                            }
                        }
                    },
                    cache:false,
                });

            });
            <?php
        }
        ?>

        function tryControl(hash,qty,ty){
            $.ajax({
                url: '<?= base_url("add-basket-card") ?>',
                method: 'POST',
                data: {
                    hash:hash,
                    qty:qty,
                    type:ty
                },
                success: function (response) {
                    if(response){
                        if(response.error){
                            toastr.warning(response.message);
                            $('.quantity[data-id="' + producthash + '"]').val(1);
                            //$('.decrease-btn, .increase-btn').trigger("click");
                        }else{
                            if(ty){
                                toastr.warning("Max Adede Ulaştınız");
                            }

                            if(response.price_dis){
                                $("#priceMain-" + hash).html(response.price);
                                $("#priceDis-" + hash + " del small").html(response.price_dis);
                                $('.quantity[data-id="' + hash + '"]').val(response.qty);
                                $("#totalBasket").html(response.total);
                            }else{
                                $("#priceMain-" + hash).html(response.price);
                                $("#totalBasket").html(response.total);
                                $("#priceMain1-" + hash).html(response.price);
                                $('.quantity[data-id="' + hash + '"]').val(response.qty);
                            }
                        }

                    }
                },
                cache:false,
            });
        }
        $("#tsr").remove();
        $(".csr").show();
        $(".draggable").css("height", "auto");
    });
</script>