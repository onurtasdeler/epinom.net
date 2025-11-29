<script src="<?= base_url() ?>assets/backend/plugins/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    CKEDITOR.replace('editor',{});
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

    $(document).ready(function() {
        //selectboxlar değiştiğinde olacaklar

    });
</script>

