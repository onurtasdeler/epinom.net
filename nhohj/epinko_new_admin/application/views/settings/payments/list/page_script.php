<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>

    function durum_degistir(id){
        var $data= $("#switch-lg_" + id).prop("checked");
        var $data_url=$("#switch-lg_" + id).data("url");
        if(typeof $data !== "undefined" && typeof $data_url!=="undefined"){
            $.post($data_url,{data : $data,table:"table_payment_methods"},function(response){
                if(response==2){
                    alertToggle(2,"Bir hata meydana geldi.","Hata");

                }else if(response==1){
                    alertToggle(1,"Durum Güncellendi.","İşlem Başarılı");
                }
            });
        }
    }
    function durum_havale_degistir(id){
        var $data= $("#switch-lg_havale_" + id).prop("checked");
        var $data_url=$("#switch-lg_havale_" + id).data("url");
        if(typeof $data !== "undefined" && typeof $data_url!=="undefined"){
            $.post($data_url,{data : $data,table:"table_payment_methods",type:1},function(response){
                if(response==2){
                    alertToggle(2,"Bir hata meydana geldi.","Hata");

                }else if(response==1){
                    alertToggle(1,"Durum Güncellendi.","İşlem Başarılı");
                }
            });
        }
    }
    $(document).ready(function() {

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url:"<?= base_url("settings-update/mail") ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            alertS(response.message,"error");
                        }else{
                            alertS(response.message,"success");
                        }
                    }else{
                        alertToggle(2,"Bir hata meydana geldi.","hata ");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });

    });
</script>




