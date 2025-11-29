<script src="assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<?php $this->load->view($view["viewFolder"]."/datatable_script.php") ?>
<script>
    function sosyalDelete(id){
        var a="";
        $.post("<?= base_url('yorum-cek') ?>",{data:id},function(response){

            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }



    function sosyal_delete(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url('yorum-sil') ?>",{data:a},function(response){
                if(response){
                    alertToggle(1,"Yorum Silindi.","İşlem Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 400);
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","Hata");
                }
            });
        }
    }


    $(document).ready(function() {
        $("#kt_datatable_filter").hide();
        //selectboxlar değiştiğinde olacaklar
    });
</script>




