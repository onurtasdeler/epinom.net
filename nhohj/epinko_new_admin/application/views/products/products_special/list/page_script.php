<script src="../assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<?php $this->load->view($view["viewFolder"]."/datatable_script.php") ?>
<script>
    function sosyalDelete(id){
        var a="";
        $.post("<?= base_url('urun-ozel-alan-cek') ?>",{data:id},function(response){

            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }

    function durum_degistir(types,id,tur=""){
        if(types!=""){
            var $data= $("#switch-lg_" + types + "_" + id).prop("checked");
            var $data_url=$("#switch-lg_" + types + "_" + id).data("url");
        }else{
            var $data= $("#switch-lg_" + id).prop("checked");
            var $data_url=$("#switch-lg_" + id).data("url");
        }

        if(typeof $data !== "undefined" && typeof $data_url!=="undefined"){
            $.post($data_url,{data : $data},function(response){
                if(response==2){
                    alertToggle(2,"Bir hata meydana geldi.","Hata");
                }else if(response==1){
                    if(tur=="is_main") {
                        alertToggle(1,"Durum Güncellendi. Sayfa Yenileniyor..","İşlem Başarılı");
                        setTimeout(function(){ window.location.reload(); }, 400);
                    }else{
                        alertToggle(1,"Durum Güncellendi.","İşlem Başarılı");
                    }
                }
            });
        }
    }

    function sosyal_delete(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url('urun-ozel-alan-sil') ?>",{data:a},function(response){
                if(response){
                    alertToggle(1,"Özel Alan Silindi.","İşlem Başarılı");
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




