<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    CKEDITOR.replace( 'icerik', {
        filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=sayfa<?= $this->uri->segment("2") ?>-yazi-icerik",
    } );
</script>
<script>
    function makaleReddetOnay(tur,id){
        if(tur==1){
            $.post("<?= base_url('user-onayla') ?>",{data : id},function(response){
                if(response==true){
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.success("İşlem Başarılı", "Başarılı");
                    setTimeout(function(){ window.location="<?= base_url() ?>yazarlik-onay-bekleyenler" }, 1000);
                }
            });
        }else if(tur==2){
            $.post("<?= base_url('user-reddet') ?>",{data : id,veri:$("#rednedeni").val()},function(response){
                if(response==true){
                    toastr.options = {
                        "closeButton": false,
                        "debug": false,
                        "newestOnTop": false,
                        "progressBar": false,
                        "positionClass": "toast-top-right",
                        "preventDuplicates": false,
                        "onclick": null,
                        "showDuration": "300",
                        "hideDuration": "1000",
                        "timeOut": "5000",
                        "extendedTimeOut": "1000",
                        "showEasing": "swing",
                        "hideEasing": "linear",
                        "showMethod": "fadeIn",
                        "hideMethod": "fadeOut"
                    };
                    toastr.success("İşlem Başarılı", "Başarılı");
                    setTimeout(function(){ window.location="<?= base_url() ?>yazarlik-onay-bekleyenler" }, 1000);
                }
            });
        }


    }

    function categoryDelete(id){
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



    function category_delete(){
        var a=$("#silinecek").val();
        if(a!=""){
            $.post("<?= base_url('sayfa-sil') ?>",{data:a},function(response){
                if(response){
                    alertToggle(1,"Sayfa Silindi.","İşlem Başarılı");
                    setTimeout(function(){ window.location.reload(); }, 400);
                }else{
                    alertToggle(2,"Bir hata meydana geldi.","Hata");
                }
            });
        }
    }

    $(document).ready(function() {
        //selectboxlar değiştiğinde olacaklar

    });
</script>

