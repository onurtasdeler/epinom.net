<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>


    $(document).ready(function() {
        setInterval(function () {
            $.ajax({
                url:"<?= base_url("talep-sohbet") ?>",
                type: 'POST',
                data: { talep:$("#id").val() },
                success: function (response) {
                    if(response){
                        $(".messages").html(response);
                        $("#chat").scrollTop($("#chat").height()+10000000);
                    }else{
                        alertToggle(2,"Bir hata meydana geldi.","hata ");
                    }
                }
            });
        }, 10000);

        $("#chat").scrollTop($("#chat").height()+10000000);
        $("#guncelleButton2").on("click",function (e){

            if($("#mesaj").val()){

            }else{
                e.preventDefault(e);
                alertS("Lütfen mesaj alanını boş bırakmayınız. ");
                return false;
            }
        });

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url:"<?= base_url("talep-guncelle/".$data["veri"]->id) ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            alertS(response.message,"error");
                        }else{
                            alertS(response.message,"success");
                            setTimeout(function(){ window.location.reload(); }, 500);
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

