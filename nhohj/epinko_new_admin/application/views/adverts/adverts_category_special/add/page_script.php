<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    //ckeditor verileri



    $(document).ready(function() {

        $( "#secimSecenek" )
            .change(function () {
                var str = "";
                if($(this).val()==2){
                    $(".secenekler").fadeIn(200);
                }else{
                    $(".secenekler").fadeOut(200);
                }
            })
            .change();


    });
</script>

