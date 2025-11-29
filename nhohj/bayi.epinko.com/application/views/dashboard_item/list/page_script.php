<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>

<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="<?= base_url() ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="<?= base_url() ?>assets/js/pages/widgets.js"></script>
<!--end::Page Vendors-->
<script>
    CKEDITOR.replace( 'icerik', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=blog-icerik",
    } );CKEDITOR.replace( 'icerikcerceve', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=blog-icerik",
    } );

    function categoryDelete(id,tur){
        var a="";

        $("#tur").val(tur);

    }

    function categoryImgdelete(){
        var tur=$("#tur").val();

            $.post("<?= base_url('main-img-sil') ?>",{data:1,tur:tur},function(response){
                if(response){
                    alertToggle(1,"Resim Silindi.","İşlem Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 1000);
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","Hata");
                }
            });
        
    }

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
