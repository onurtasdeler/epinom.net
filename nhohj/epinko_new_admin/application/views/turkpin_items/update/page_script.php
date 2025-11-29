<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js?v=<?= time(); ?>"></script>

<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>

    $(function () {

        <?php
        if($this->settings->lang == 1){
            $getLang = getTable("table_langs", array("status" => 1));
            if($getLang){
                foreach ($getLang as $item) {
                ?>
                $ck<?= $item->id ?> = CKEDITOR.replace('icerik_<?= $item->id ?>', {
                    filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
                });
                $ck2<?= $item->id ?> = CKEDITOR.replace('icerik2_<?= $item->id ?>', {
                    filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
                });
                $ck3<?= $item->id ?> = CKEDITOR.replace('icerik3_<?= $item->id ?>', {
                    filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
                });
                $ck<?= $item->id ?>.on('change', function () {
                    $ck<?= $item->id ?>.updateElement();
                });

                $ck2<?= $item->id ?>.on('change', function () {
                    $ck2<?= $item->id ?>.updateElement();
                });

                $ck3<?= $item->id ?>.on('change', function () {
                    $ck3<?= $item->id ?>.updateElement();
                });
            <?php
            }
            }
        }
        ?>
    });

    function deleteModal(id){
        var a="";
        $.post("<?= base_url('sayfa-cek') ?>",{data:id},function(response){
            if(response){
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>" );
                $("#silinecek").val(id);
            }else{
                alertToggle(2,"Bir hata meydana geldi.","hata ");
            }
        });
    }

    function deleteModalSubmit(){
        var a=$("#silinecek").val();
        var tur=1;
        if(a!=""){
            $.post("<?= base_url('sayfa-img-sil') ?>",{data:a,tur:tur},function(response){
                if(response){
                    alertToggle(1,"Resim Silindi.","Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 1000);
                }else{
                    alertToggle(2,"Hata","Hata");
                }
            });
        }
    }

    $(document).ready(function() {

        $("#guncelleForm").on("submit",function (e){
            e.preventDefault();
            var formData = new FormData(this);
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            $.ajax({
                url:"<?= base_url("sayfa-guncelle/".$data["veri"]->id) ?>",
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


</script>

