<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>

<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>

<!--end::Page Vendors-->

<script>

    //ckeditor verileri

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
<?= getcur(); ?>
                } );

                <?php

            }

        }<?= getcur(); ?>

    }

    ?>
<?= getcur(); ?>


    function satisTextUpdate(deger){<?= getcur(); ?>

        if(deger=="a"){

            $("#satisText").removeClass("text-success");

            $("#satisText").addClass("text-danger");

            $("#satisText").html("Fiyat Giriniz");

        }else{

            $("#satisText").removeClass("text-danger");

            $("#satisText").addClass("text-success");

            $("#satisText").html(deger.toFixed(2).toString() + " ₺");

        }



    }

    function karTextUpdate(deger){

        $("#karText").removeClass("text-danger");

        $("#karText").addClass("text-success");

        $("#karText").html(deger.toFixed(2).toString() + " ₺");

    }

    function indTextUpdate(deger,deger2){

        $("#indirimText").removeClass("text-danger");

        $("#indirimText").addClass("text-success");

        $("#indirimText").html(deger.toFixed(2).toString() + " ₺");

        $("#indText").removeClass("text-danger");

        $("#indText").addClass("text-success");

        $("#indText").html(deger2.toFixed(2).toString() + " ₺");

    }



    $(document).ready(function() {



    











    });

</script>



