<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    function ddd(){
        alertS("Lütfen Bekleyiniz..","warning");
    }
    $(document).ready(function() {
        $("#kayit").on("click",function (){

        });
        //selectboxlar değiştiğinde olacaklar
        $(".secimler").change(function() {
            if(this.checked) {
                var id = $(this).data("value");
                //var id = $(this).val();
                if (id == 0) {

                } else {
                    $.ajax({
                        type: 'POST',
                        url: "<?= base_url() ?>turkpin-get-product-2",
                        data: {data: id},
                        success: function (sonuc) {

                            $("#cols" + id).fadeIn(300);
                            $("#bd" + id).html(sonuc);
                        }
                    });
                }
            }else{
                $("#cols" + $(this).data("value")).fadeOut(300);
            }
        });

    });
</script>

