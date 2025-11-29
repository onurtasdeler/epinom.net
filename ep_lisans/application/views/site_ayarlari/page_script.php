<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/assets/css/editors/tinymce.css?ver=3.1.2">
<script src="<?= base_url() ?>assets/assets/js/libs/editors/tinymce.js?ver=3.1.2"></script>
<script src="<?= base_url() ?>assets/assets/js/editors.js?ver=3.1.2"></script>

<script>

    $(document).ready(function (){
        $("#smsayar").on("submit",function (e){
            tinymce.activeEditor.save();
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"<?= base_url("site-ayarlari?ty=1") ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            als("Hata meydana geldi","error");
                        }else{
                            als("İşlem Başarılı","success");
                            setTimeout(function (){
                                window.location.reload();
                            },500);
                        }
                    }else{
                        als("Hata meydana geldi","error");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        })



    })
</script>