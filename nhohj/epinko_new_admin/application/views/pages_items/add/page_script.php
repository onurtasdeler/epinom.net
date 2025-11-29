<script>
    $("[tags-input]").select2({
        tags: true,
        tokenSeparators: [','],
        maximumSelectionLength: 20,
        maximumInputLength: 20
    });

    let dataBefore = [];

    $("[tags-input]").on('select2:open', function () {
        dataBefore = $("[tags-input]").select2('data').map(item => item.id);
    });

    $("[tags-input]").on('select2:select', function (e) {
        const selectedItems = $("[tags-input]").select2('data').length;
        if (selectedItems > 20) {
            $("[tags-input]").val(dataBefore).trigger('change');
            alert('En fazla 20 seçim yapabilirsiniz!');
        }
    });

    $("[tags-input]").on('select2:unselect', function () {
        dataBefore = $("[tags-input]").select2('data').map(item => item.id);
    });
</script>
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
    <?php
    }
    }
    }
    ?>

    $(document).ready(function() {
        //selectboxlar değiştiğinde olacaklar

    });
</script>

