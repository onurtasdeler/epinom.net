<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>

<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    $(function(){
        $ck1 = CKEDITOR.replace('icerik_tr', {
            filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
        });
        $ck1.on('change', function() {
            $ck1.updateElement();
        });
        $ck2 = CKEDITOR.replace('icerik_en', {
            filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
        });
        $ck2.on('change', function() {
            $ck2.updateElement();
        });
      
    });


    function deleteModal(id,tur){
        var a="";
        $.post("<?= base_url('ilan-cek') ?>",{data:id},function(response){
            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
                $("#tur").val(tur);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }

    function deleteModalSubmit(){
        var a=$("#silinecek").val();
        var tur=$("#tur").val();
        if(a!=""){
            $.post("<?= base_url('ilan-img-sil') ?>",{data:a,tur:tur},function(response){
                if(response){
                    alertToggle(1,"Resim Silindi.","Başarılı");
                    //setTimeout(function(){ window.location.reload(); }, 1000);
                }else{
                    alertToggle(2,"Hata","Hata");
                }
            });
        }
    }
    $(document).ready(function() {

        $("#status").on("change",function (){
           if($(this).val()==2){
               $("#redNedeni").fadeIn(500);
           } else{
               $("#redNedeni").fadeOut(500);
           }
        });

        $("#price").on('input keyup propertychange paste', function () {
            var value = $("#price").val();
            if (value.length == 0) {
                $("#hesaplanan").val();
                $("#kazancy").html("-");
                $("#komisyontu").html("-");
                $("#komisyonyu").html("-");
                $("#birimfiyat").html("-");
            } else {
                $.post("<?= base_url('get-ad-price-commission') ?>", {
                    data: value,
                    id:<?= $data["veri"]->id ?>,
                    kom:$("#hesaplanan").val(),
                }, function (response) {
                    if (response.err) {
                        toastr.warning(response.message);
                    } else {
                        $("#kazancy").html(response.kazanc);
                        $("#komisyontu").html(response.komt);
                        $("#komisyonyu").html(response.kom);
                        $("#birimfiyat").html(response.price);
                    }
                });
            }
        });

        $("#hesaplanan").on('input change keyup propertychange paste', function () {
            var value = $("#hesaplanan").val();
            if (value.length == 0) {
                $("#hesaplanan").val();
                $("#kazancy").html("-");
                $("#komisyontu").html("-");
                $("#komisyonyu").html("-");
                $("#birimfiyat").html("-");
            } else {
                $.post("<?= base_url('get-ad-price-commission') ?>", {
                    data: $("#price").val(),
                    id:<?= $data["veri"]->id ?>,
                    kom:value,
                }, function (response) {
                    if (response.err) {
                        toastr.warning(response.message);
                    } else {
                        $("#kazancy").html(response.kazanc);
                        $("#komisyontu").html(response.komt);
                        $("#komisyonyu").html(response.kom);
                        $("#birimfiyat").html(response.price);
                    }
                });
            }
        });

        $("#ilan_main_cat").on("change",function (){
            if($(this).val()!="" && $(this).val()!=0){
                $.post("<?= base_url('ilan-kategori-doldur') ?>",{data:$(this).val(),tur:1},function(response){
                    if(response){
                        $("#ilanUst").html(response);
                        $("#altCat").html("<option>Üst Kategori Seçiniz</option>");
                    }else{
                        $("#ilanUst").html("");
                        $("#altCat").html("");
                        alertToggle(2,"Bir hata meydana geldi.","hata ");
                    }
                });
            }
        });
        $("#ilanUst").on("change",function (){
            if($(this).val()!="" && $(this).val()!=0){
                $.post("<?= base_url('ilan-kategori-doldur') ?>",{data:$(this).val(),tur:2},function(response){
                    if(response){
                        if(response==""){
                            $("#altCat").html("<option>Kategori Bulunamadı</option>");
                        }else{
                            $("#altCat").html(response);
                        }
                    }else{
                        alertToggle(2,"Bir hata meydana geldi.","hata ");
                    }
                });
            }
        });
        //turkpin selectbox ajax


        $('.float-number').keypress(function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });



        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            $.ajax({
                url:"<?= base_url("ilan-guncelle/".$data["veri"]->id) ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            alertS(response.message,"error");
                        }else{
                            alertS(response.message,"success");

                        }
                    }else{
                        alertToggle(2,"Bir hata meydana geldi.","hata ");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });

    });
</script>

