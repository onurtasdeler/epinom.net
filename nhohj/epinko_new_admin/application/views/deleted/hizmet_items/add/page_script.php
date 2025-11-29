<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    <?php
    if($this->settings->lang==1){
        $getLang=getTable("table_langs",array("status" => 1));
        if($getLang){
            foreach ($getLang as $item) {
                ?>
                CKEDITOR.replace( 'icerik_<?= $item->id ?>', {
                    filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
                } );
                CKEDITOR.replace( 'icerik2_<?= $item->id ?>', {
                    filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
                } );

                <?php
            }
        }
    }
    ?>


    $(document).ready(function() {
        //selectboxlar değiştiğinde olacaklar

    });
</script>

