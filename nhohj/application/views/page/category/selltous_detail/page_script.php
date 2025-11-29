<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        let befores="";
        
      
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

        $('.decrease-btn, .increase-btn').on('click', function () {
            var producthash = $(this).data('id');
            var quantity = parseInt($(this).parent().find('.quantity[data-id="' + producthash + '"]').val());

            if ($(this).hasClass('increase-btn')) {
                quantity++;
            } else {
                if (quantity > 1) {
                    quantity--;
                }
            }
            $(this).parent().find('.quantity[data-id="' + producthash + '"]').val(quantity);
            if(quantity==0){
                $(this).parent().find('.quantity[data-id="' + producthash + '"]').val(1);
            }else{
                
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
                       url: '<?= base_url("purchase-from-us") ?>',
                       method: 'POST',
                       data: {
                           hash:data,
                           qty:parseInt($('.quantity_satis[data-id="' + data + '"]').val()),
                           spefield:veri,
                       },
                       success: function (response) {
                           if(response){
                               if(response.error){
                                   toastr.warning(response.message);

                                   //$('.decrease-btn, .increase-btn').trigger("click");
                               }else{
                                   toastr.success("<?= (lac()==1)?"Başarıyla satın alındı. Teslimat sayfasına yönlendirileceksiniz.":"Purchase successful. You will be redirected to the delivery page." ?>");
                                   setTimeout(()=>{
                                       location.href = response.link;
                                   },1000);
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

        $(".btnSellToUsBid").on("click",function (){
           var data=$(this).data("token");
           if(data){
               if($("#spe-" + data + "_alis").val()){
                   var veri=$("#spe-" + data + "_alis").val();
                   var validChars = /^[A-Za-z0-9çğıöşüÇĞİÖŞÜ#\-_]+$/; // Türkçe karakterler dahil
                   if (!validChars.test(veri)) {
                      toastr.warning("Lütfen ilgili alana düzgün veri giriniz.");
                   }else{
                       //ajax

                   $.ajax({
                       url: '<?= base_url("sell-to-us") ?>',
                       method: 'POST',
                       data: {
                           hash:data,
                           qty:parseInt($('.quantity_alis[data-id="' + data + '"]').val()),
                           spefield:veri,
                       },
                       success: function (response) {
                           if(response){
                               if(response.error){
                                   toastr.warning(response.message);
                                   //$('.decrease-btn, .increase-btn').trigger("click");
                               }else{
                                   toastr.success("<?= (lac()==1)?"Bize sat talebiniz oluşturuldu. Teslimat sayfasına yönlendirileceksiniz.":"Your sell request has been created. You will be redirected to the delivery page." ?>");
                                   setTimeout(()=>{
                                    location.href = response.link;
                                   },1000);
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