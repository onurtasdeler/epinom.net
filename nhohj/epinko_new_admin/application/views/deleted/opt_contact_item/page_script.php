<script>
    
</script>
<script src="<?= base_url() ?>assets/backend/js/jquery-ui.min.js"></script>


<script>

    
$(document).ready(function() {
        $("#contactForm").on("submit",function(){
            $.post("<?= base_url('contact-update') ?>",$(this).serialize(),function(response){
                if(response==true){
                    alertToggle(1,"Güncelle Başarılı","Başarılı!");
                }else{
                    alertToggle(2,"Bir Hata meydana geldi.","Hata!");
                }
            });
        });
        //selectboxlar değiştiğinde olacaklar
    });
   
</script
