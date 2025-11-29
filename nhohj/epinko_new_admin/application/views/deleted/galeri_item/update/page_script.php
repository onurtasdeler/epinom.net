<script src="<?= base_url() ?>assets/backend/plugins/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    function categoryDelete(id,tur){
        var a="";
        $.post("<?= base_url('galeri-cek') ?>",{data:id},function(response){

            if(response){
                $("#makaleId").html(response);
                $("#silinecek").val(id);
                $("#tur").val(tur);
            }else{
                alertToggle(2,"Hata","Hata");
            }
        });
    }

    function categoryImgdelete(){
        var a=$("#silinecek").val();
        var tur=$("#tur").val();
        if(a!=""){
            $.post("<?= base_url('galeri-img-sil') ?>",{data:a,tur:tur},function(response){
                if(response){
                    alertToggle(1,"Galeri Silindi.","Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 1000);
                }else{
                    alertToggle(2,"Hata","Hata");
                }
            });
        }
    }
    CKEDITOR.replace('editor',{});

    $(document).ready(function() {
        //selectboxlar değiştiğinde olacaklar

    });
</script>

