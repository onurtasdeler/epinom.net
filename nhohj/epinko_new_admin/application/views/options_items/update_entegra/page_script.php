<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<script src="assets/backend/plugins/custom/datatables/datatables.bundle.js"></script>

<!--end::Page Vendors-->
<?php $this->load->view($view["viewFolder"]."/datatable_script.php") ?>

<script>


    $(document).ready(function() {

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);
            
            $.ajax({
                url:"<?= base_url("entegrasyon-bilgileri?t=".$_GET["t"]) ?>",
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
    $(document).ready(function() {
        $("#kt_datatable_filter").hide();
        //selectboxlar değiştiğinde olacaklar
    });
</script>

