<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>

    $(document).ready(function() {


        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);
            alertS("Lütfen Bekleyiniz..","warning");
            $.ajax({
                url:"<?= base_url("ayarlar/sms-entagrasyon-guncelle/1") ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            alertS(response.message,"error");
                            setTimeout()
                        }else{
                            alertS(response.message,"success");
                            setTimeout(function() {window.location.reload()}, 600);
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

