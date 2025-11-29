<script src="assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<?php $this->load->view($this->viewFolder."/datatable_script.php") ?>
<script>
    function categoryDelete(id){
        var a="";
        $.post("<?= base_url('galeri-cek') ?>",{data:id},function(response){
            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
            }else{
                alertToggle(2,"Hata Meydana Geldi. ","Hata");
            }
        });
    }



    function category_delete(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url('galeri-sil') ?>",{data:a},function(response){
                if(response){
                    alertToggle(1,"Galeri Silindi.","Success");
                    setTimeout(function(){ window.location.reload(); }, 400);
                }else{
                    alertToggle(2,"Hata Meydana Geldi. ","Hata");
                }
            });
        }
    }


    $(document).ready(function() {
        $("#kt_datatable_filter").hide();
        //selectboxlar değiştiğinde olacaklar
    });
</script>




