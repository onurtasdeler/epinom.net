<script>
    
</script>
<script src="<?= base_url() ?>assets/backend/js/jquery-ui.min.js"></script>


<script>

    
$(document).ready(function() {
        $("#contactForm").on("submit",function(){
            $.post("<?= base_url('password-update') ?>",$(this).serialize(),function(response){
                response=$.trim(response);
                if(response=="1"){
                    alertToggle(1,"Güncelle Başarılı","Başarılı! Çıkış Yapılıyor. Bekleyiniz");
                    setTimeout(function(){ window.location.href="<?= base_url("exit") ?>" }, 2000);
                }else if(response=="2"){
                    alertToggle(2,"Şifreler Uyuşmuyor.","Hata!");
                }else{
                    alertToggle(2,"Lütfen bilgileri kontrol ediniz.","Hata!");
                }
            });
        });
        //selectboxlar değiştiğinde olacaklar
    });
   
</script
