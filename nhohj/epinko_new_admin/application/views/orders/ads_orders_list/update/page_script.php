<script src="<?= base_url() ?>assets/backend/js/pages/custom/chat/chat.js?v=7.2.9"></script>

<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    


    $(document).ready(function() {

        $("#status").on("change",function (){
           if($(this).val()==4){
               $("#redNedeni").fadeIn(500);
           } else{
               $("#redNedeni").fadeOut(500);
           }
        });

        //turkpin selectbox ajax


        $('.float-number').keypress(function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);

            alertS("Lütfen Bekleyiniz..","warning");
            $.ajax({
                url:"<?= base_url("ilan-siparis-guncelle/".$data["veri"]->id) ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            alertS(response.message,"error");
                        }else{
                            alertS(response.message,"success");
                            //setTimeout(function() {window.location.reload()}, 600);
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

