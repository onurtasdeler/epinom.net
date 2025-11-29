<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    CKEDITOR.replace( 'icerik', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=blog-icerik",
    } );



    $(document).ready(function() {



        $("#imgTempForm").on("submit",function(e){
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: "<?= base_url('anasayfa-save') ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response==true){
                        alertToggle(1,"Güncelleme Başarılı","Başarılı");
                    }else{
                        alertToggle(2,"Bir hata meydana geldi.","Başarısız!");
                    }
                },
                cache: true,
                contentType: false,
                processData: false
            });


        });



    });
   
</script>
