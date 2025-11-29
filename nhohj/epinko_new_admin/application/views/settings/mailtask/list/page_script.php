<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script>
    function sosyalDelete(id){
        var a="";
        $.post("<?= base_url('get-record') ?>",{data:id,field:"name",table:"table_mail_templates"},function(response){
            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }

    function durum_degistir(id){
        var $data= $("#switch-lg_" + id).prop("checked");
        var $data_url=$("#switch-lg_" + id).data("url");
        if(typeof $data !== "undefined" && typeof $data_url!=="undefined"){
            $.post($data_url,{data : $data},function(response){
                if(response==2){
                    alertToggle(2,"Bir hata meydana geldi.","Hata");

                }else if(response==1){
                    alertToggle(1,"Durum Güncellendi.","İşlem Başarılı");
                }
            });
        }
    }

    function sosyal_delete(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url('delete-record') ?>",{data:a,table:"table_mail_templates",deleteField:"id"},function(response){
                if(response){
                    if(response.hata=="var"){
                        alertToggle(2,"Bir hata meydana geldi.","Hata");
                    }else{
                        alertToggle(1,"Şablon Silindi.","İşlem Başarılı");
                        setTimeout(function(){ window.location.reload(); }, 400);
                    }
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




