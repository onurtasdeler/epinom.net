
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>


    function deleteModal(id,tur){
        var a="";
        $.post("<?= base_url('uye-cek') ?>",{data:id},function(response){
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
            $.post("<?= base_url('uye-img-sil') ?>",{data:a,tur:tur},function(response){
                if(response){
                    alertToggle(1,"Resim Silindi.","Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 1000);
                }else{
                    alertToggle(2,"Hata","Hata");
                }
            });
        }
    }
    $(document).ready(function() {
        $("#yesBan").on("click",function(){
            $.post("<?= base_url("uye-banla") ?>",{id:<?= $data["veri"]->id ?>},function(response){
                if(response){
                    if(response.hata=="var"){
                        alertToggle(2,response.message);
                    }else{
                        alertToggle(1,"Üye Başarılı şekilde banlandı");
                        setTimeout(function (){
                            window.location.reload();
                        },1000);
                    }
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","hata ");
                }
            });
        });
        $("#yesBan2").on("click",function(){
            $.post("<?= base_url("uye-banla") ?>",{id:<?= $data["veri"]->id ?>},function(response){
                if(response){
                    if(response.hata=="var"){
                        alertToggle(2,response.message);
                    }else{
                        alertToggle(1,"Üye Banı kaldırıldı");
                        setTimeout(function (){
                            window.location.reload();
                        },1000);
                    }
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","hata ");
                }
            });
        });

        $("#onayMailGonder").on("click",function (){
            $.post("<?= base_url("uye-manuel-dogrulama") ?>",{id:<?= $data["veri"]->id ?>},function(response){
                if(response){
                    if(response.hata=="var"){
                        alertToggle(2,"Mail gönderilirken hata meydana geldi");
                    }else{
                        alertToggle(1,"Onay maili başarılı şekilde gönderildi.","hata ");
                    }
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","hata ");
                }
            });
        });

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);
            if($("#password").val()!="" && $("#passwordTry").val()==""){
                alertS("Her iki şifre alanınıda doldur.","error");
            }else if($("#password").val()=="" && $("#passwordTry").val()!=""){
                alertS("Her iki şifre alanınıda doldur.","error");
            }else{
                if($("#password").val()==$("#passwordTry").val()){
                    $.ajax({
                        url:"<?= base_url("uye-guncelle/".$data["veri"]->id) ?>",
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
                }else{
                    alertS("Şifreler Uyuşmamaktadır.","error");
                }
            }



        });

    });
</script>

