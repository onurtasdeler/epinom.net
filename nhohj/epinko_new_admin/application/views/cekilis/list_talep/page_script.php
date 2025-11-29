<script src="assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<?php $this->load->view($view["viewFolder"]."/datatable_script.php") ?>
<script>
    function sosyalDelete(id){
        var a="";
        $.post("<?= base_url('cekilis-talep-cek') ?>",{data:id},function(response){

            if(response){
                $("#makaleId").html('<strong style="color:green">' + response.nick_name + "</strong>" );
                $("#silinecek").val(response.usid);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }

    function yetkiModal(id,tur){
        var a="";
        $.post("<?= base_url('cekilis-talep-cek') ?>",{data:id},function(response){
            if(response){
                if(tur==1){
                    $("#makaleIdmenu2").html('<strong style="color:green">' + response.nick_name + "</strong>" );
                    $("#silinecekmenu2").val(response.usid);
                    $("#turmenu3").val(tur);
                }else{
                    $("#makaleIdmenu3").html('<strong style="color:green">' + response.nick_name + "</strong>" );
                    $("#silinecekmenu3").val(response.usid);
                    $("#turmenu3").val(tur);
                }

            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }
    function yetkiIslem(id=""){
        if(id!=""){
            var a=$("#silinecekmenu3").val();
        }else{
            var a=$("#silinecekmenu2").val();
        }

        if(a!=""){
            $.post("<?= base_url('cekilis-yetki-ver') ?>",{data:a,tur:$("#turmenu3").val(),red:$("#red_nedeni").val()},function(response){
                if(response){
                    alertToggle(1,"Üyenin çekiliş yetki talebi reddedildi.","İşlem Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 400);
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","Hata");
                }
            });
        }
    }



    function sosyal_delete(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url('cekilis-talep-sil') ?>",{data:a},function(response){
                if(response){
                    alertToggle(1,"Çekiliş Yetki Talebi Silindi.","İşlem Başarılı");
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




