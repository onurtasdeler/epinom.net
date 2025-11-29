
<!--end::Page Vendors-->
<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<script src="<?= base_url() ?>assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<?php $this->load->view($this->viewFolder."/datatable_script.php") ?>
<!--end::Page Vendors-->
<script>
    CKEDITOR.replace( 'icerik', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=sayfa<?= $this->uri->segment("2") ?>-yazi-icerik",
    } );

    function categoryDelete(id){
        var a="";
        $.post("<?= base_url('sayfa-cek') ?>",{data:id},function(response){

            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }



    function category_delete(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url('sayfa-sil') ?>",{data:a},function(response){
                if(response){
                    alertToggle(1,"Sayfa Silindi.","İşlem Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 400);
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","Hata");
                }
            });
        }
    }

</script>
<script>


    $(document).ready(function() {
        //selectboxlar değiştiğinde olacaklar

    });
</script>

