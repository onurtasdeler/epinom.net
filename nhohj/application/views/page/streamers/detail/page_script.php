<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        let befores="";
        $("#donationForm").on("submit",function (e) {
            e.preventDefault();
            $("#donationForm button[type=submit]").attr("disabled",true);
            var data = {
                streamerId: $("#streamerId").val(),
                username: $("#username").val(),
                message: $("#message").val(),
                amount: $("#donationAmount").val()
            }
            $.ajax({
                url: '<?= base_url("donate-to-streamer") ?>',
                method: 'POST',
                data: data,
                success:function(response) {
                    if(response) {
                        if(response.error) {
                            toastr.warning(response.message)
                        } else {
                            toastr.success("<?= (lac()==1)?"Bağışınız alınmıştır.":"Your donation has been received." ?>")
                        }
                    }
                },
                error:function(err) {
                    toastr.warning("<?= lac()==1?"Bilinmeyen bir hata oluştu.":"An unknown error occured." ?>")
                }
            }).done(()=>{
                $("#donationForm button[type=submit]").attr("disabled",false);
            })
        });
        $("#donationYoutubeForm").on("submit",function (e) {
            e.preventDefault();
            $("#donationYoutubeForm button[type=submit]").attr("disabled",true);
            var data = {
                streamerId: $("#youtubeStreamerId").val(),
                username: $("#youtubeUsername").val(),
                message: $("#youtubeMessage").val(),
                amount: $("#donationYoutubeAmount").val()
            }
            $.ajax({
                url: '<?= base_url("donate-to-streamer") ?>',
                method: 'POST',
                data: data,
                success:function(response) {
                    if(response) {
                        if(response.error) {
                            toastr.warning(response.message)
                        } else {
                            toastr.success("<?= (lac()==1)?"Bağışınız alınmıştır.":"Your donation has been received." ?>")
                        }
                    }
                },
                error:function(err) {
                    toastr.warning("<?= lac()==1?"Bilinmeyen bir hata oluştu.":"An unknown error occured." ?>")
                }
            }).done(()=>{
                $("#donationYoutubeForm button[type=submit]").attr("disabled",false);
            })
        });
        
        $(".btnBasket").on("click",function (){
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
                        }).done(()=>{
                            $.ajax({
                                url:'<?= base_url("get-basket-qty") ?>',
                                type:'GET',
                                success:function(resp) {
                                    $("#basketCount").text(resp);
                                }
                            })
                        });
                    }
                }
            }else{
                $('.quantity[data-id="' + hash + '"]').val(1);
                tryControl(hash,1);
            }

        });
        $('.decrease-btn, .increase-btn').on('click', function () {
            var producthash = $(this).data('id');
            var quantity = parseInt($('.quantity[data-id="' + producthash + '"]').val());

                if ($(this).hasClass('increase-btn')) {
                    quantity++;
                } else {
                    if (quantity > 1) {
                        quantity--;
                    }
                }

                $('.quantity[data-id="' + producthash + '"]').val(quantity);
                if(quantity==0){
                    tryControl(producthash,quantity);
                    $('.quantity[data-id="' + producthash + '"]').val(1);
                }else{
                    $.ajax({
                        url: '<?= base_url("product-change-qty") ?>',
                        method: 'POST',
                        data: {
                            hash:producthash,
                            qty:quantity,
                        },
                        success: function (response) {
                            if(response){
                                if(response.error){
                                    toastr.warning(response.message);
                                    $('.quantity[data-id="' + producthash + '"]').val(1);
                                    if(quantity==1){

                                    }else{
                                        tryControl(producthash,quantity);
                                    }

                                    //$('.decrease-btn, .increase-btn').trigger("click");
                                }else{
                                    if(response.message){
                                        toastr.warning(response.message);
                                    }
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
                        },
                        cache:false,
                    });
                }



        });
        function tryControl(hash,qty){
            $.ajax({
                url: '<?= base_url("product-change-qty") ?>',
                method: 'POST',
                data: {
                    hash:producthash,
                    qty:quantity,
                },
                success: function (response) {
                    if(response){
                        if(response.error){
                            toastr.warning(response.message);
                            $('.quantity[data-id="' + producthash + '"]').val(1);
                            //$('.decrease-btn, .increase-btn').trigger("click");
                        }else{
                            if(response.price_dis){
                                $("#priceMain-" + producthash).html(response.price);
                                $("#priceDis-" + producthash + " del small").html(response.price_dis);
                                $('.quantity[data-id="' + producthash + '"]').val(response.qty);
                            }else{

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
        $(".speField").on("input", function (e) {
            var validChars = /^[A-Za-z0-9çğıöşüÇĞİÖŞÜ#\-_]*$/; // Türkçe karakterler dahil
            var newValue = $(this).val();

            // Geçerli karakterlerin kontrolü
            if (!validChars.test(newValue)) {
                newValue = newValue.replace(/[^A-Za-z0-9çğıöşüÇĞİÖŞÜ#\-_]/g, '');
            }

            // Maksimum uzunluk kontrolü (100 karakter)
            if (newValue.length > 100) {
                newValue = newValue.substring(0, 100);
            }

            $(this).val(newValue);
        });

        $(".speField").on("keydown", function (e) {
            // Geri tuşu, silme tuşu, tab tuşu, ok tuşları, enter tuşu vb. için kontrol
            if (e.key.length === 1 && !/^[A-Za-z0-9çğıöşüÇĞİÖŞÜ#\-_]$/.test(e.key) && !e.ctrlKey && !e.metaKey) {
                e.preventDefault();
            }
        });

        $(".speField").on("paste", function (e) {
            var pastedData = (e.originalEvent || e).clipboardData.getData('text/plain');
            var validChars = /^[A-Za-z0-9çğıöşüÇĞİÖŞÜ#\-_]+$/; // Türkçe karakterler dahil
            if (!validChars.test(pastedData)) {
                e.preventDefault();
            }
        });

        $(".btnBid").on("click",function (){
           var data=$(this).data("token");
           if(data){
               if($("#spe-" + data).val()){
                   var veri=$("#spe-" + data).val();
                   var validChars = /^[A-Za-z0-9çğıöşüÇĞİÖŞÜ#\-_]+$/; // Türkçe karakterler dahil
                   if (!validChars.test(veri)) {
                      toastr.warning("Lütfen ilgili alana düzgün veri giriniz.");
                   }else{
                       //ajax

                   $.ajax({
                       url: '<?= base_url("add-basket-card") ?>',
                       method: 'POST',
                       data: {
                           hash:data,
                           qty:1,
                           spefield:veri,
                       },
                       success: function (response) {
                           if(response){
                               if(response.error){
                                   toastr.warning(response.message);

                                   //$('.decrease-btn, .increase-btn').trigger("click");
                               }else{
                                   toastr.success("<?= (lac()==1)?"Sepete Eklendi":"Added Basket" ?>");
                               }

                           }
                       },
                       cache:false,
                   });
               }

               }else{
                   $("#spe-" + data).css("border","1px solid red");
                   toastr.warning("Lütfen ilgili alanı doldurunuz.");
               }
           }
        });

    });
</script>