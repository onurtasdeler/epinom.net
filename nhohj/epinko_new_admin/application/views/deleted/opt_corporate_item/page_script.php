
<script src="<?= base_url() ?>assets/backend/js/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>


<script>
    CKEDITOR.replace( 's_alt_icerik', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=hakkimizda-alt-icerik",
    } );
    CKEDITOR.replace( 'misyon', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=hakkimizda-yazi-icerik",
    } );
    CKEDITOR.replace( 'kalite', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=hakkimizda-yazi-icerik",
    } );
    CKEDITOR.replace( 'firma', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=hakkimizda-yazi-icerik",
    } );
    CKEDITOR.replace( 'baskan', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=hakkimizda-yazi-icerik",
    } );
    CKEDITOR.replace( 'genelmudur', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=hakkimizda-yazi-icerik",
    } );


    $(document).ready(function() {
        
      

       /* $("#imgTempForm").on("submit",function(e){
            e.preventDefault();    
            var formData = new FormData(this);

            $.ajax({
                url: "<?= base_url('corporate-save') ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response==true){
                        alertToggle(1,"Güncelleme Başarılı","Başarılı");
                        window.location.reload();
                    }else{
                        alertToggle(2,"Bir hata meydana geldi.","Başarısız!");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

            
        });*/

    

    });
   
</script
