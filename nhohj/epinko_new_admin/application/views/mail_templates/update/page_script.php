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
                url:"<?= base_url("sablon-guncelle/".$data["veri"]->id) ?>",
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

