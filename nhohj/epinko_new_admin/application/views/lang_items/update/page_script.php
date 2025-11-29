<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    $(document).ready(function() {
        $("#guncelleForm").on("submit",function (){
            $.post("<?= base_url("dil-guncelle/".$data["veri"]->id) ?>",$("#guncelleForm").serialize(),function(response){
                if(response){
                    if(response.err){
                        alertS(response.message,"error");
                    }else{
                        alertS(response.message,"success");

                    }
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","hata ");
                }
            });
        });

    });
</script>

