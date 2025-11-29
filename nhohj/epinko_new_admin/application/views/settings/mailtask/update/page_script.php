<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<script src="<?= base_url() ?>assets/backend/tinymce/tinymce.bundle.js"></script>
<script src="<?= base_url() ?>assets/backend/tinymce/tinymce.js"></script>
<script>

    $(function () {

        <?php
        if($this->settings->lang == 1){
        $getLang = getTable("table_langs", array("status" => 1));
        if($getLang){
        foreach ($getLang as $item) {
        ?>
        tinymce.init({
            selector: 'textarea#icerik_<?= $item->id ?>',
            language_url: '<?= base_url("assets/backend/tinymce/") ?>tr.js',
            language: 'tr',
            cleanup : false,
            statusbar : false,


            menubar: false,
            toolbar: ['styleselect fontselect fontsizeselect',
                'undo redo | cut copy paste | bold italic | link image | alignleft aligncenter alignright alignjustify',
                'bullist numlist | outdent indent | blockquote subscript superscript | advlist | autolink | lists charmap | print preview |  code'],
            plugins : 'advlist autolink link image lists charmap print preview code'

        });
        <?php
        }
        }
        }
        ?>
    });

</script>
    <script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
    <script>


    $(document).ready(function() {

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url:"<?= base_url("ayarlar/sablon-guncelle/".$data["veri"]->id) ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response){
                        if(response.err){
                            alertS(response.message,"error");
                        }else{
                            alertS(response.message,"success");
                            setTimeout(function() {window.location.reload()}, 1000);


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

