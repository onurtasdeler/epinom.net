<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>
<!--end::Page Vendors-->
<script>
    $(function() {
        CKEDITOR.replace('paymenTextEditor', {
            filebrowserImageUploadUrl: "<?= base_url(); ?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
        });
    });

    function deleteModal(id, tur) {
        var a = "";
        $("#silinecek").val(1);
        $("#tur").val(tur);
    }

    function deleteModalSubmit() {
        var a = 1;
        var tur = $("#tur").val();
        if (a != "") {
            $.post("<?= base_url('logo-img-sil') ?>", {
                data: a,
                tur: tur
            }, function(response) {
                if (response) {
                    alertToggle(1, "Resim Silindi.", "Başarılı");
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                } else {
                    alertToggle(2, "Hata", "Hata");
                }
            });
        }
    }

    $(document).ready(function() {

        $("#guncelleForm").on("submit", function(e) {
            e.preventDefault();
            
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            
            var formData = new FormData(this);
            $.ajax({
                url: "<?= base_url("settings-update/genel") ?>",
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response) {
                        if (response.err) {
                            alertS(response.message, "error");
                        } else {
                            alertS(response.message, "success");
                        }
                    } else {
                        alertToggle(2, "Bir hata meydana geldi.", "hata ");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });

    });
</script>