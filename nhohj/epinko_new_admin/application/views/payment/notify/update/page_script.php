<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/custom/chat/chat.js?v=7.2.9"></script>
<!--end::Page Vendors-->
<script>


    $(document).ready(function() {

        $("#status").change(function (){
            if($(this).val()==2){
                $("#redneden").fadeIn(200);
            }else{
                $("#redneden").fadeOut(200);
            }
        });

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url:"<?= base_url("odeme-bildirim-guncelle/".$data["veri"]->id) ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            alertS(response.message,"error");
                        }else{
                            alertS(response.message,"success");
                            //setTimeout(function(){ window.location.reload(); }, 500);
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

