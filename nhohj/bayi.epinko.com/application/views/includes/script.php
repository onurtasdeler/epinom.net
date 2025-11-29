<?php
/**
 * Created by PhpStorm.
 * User: brkki
 * Date: 28.04.2021
 * Time: 12:01
 */
?>

<script>var HOST_URL = "/";</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->


<script src="<?= base_url() ?>assets/backend/plugins/global/plugins.bundle.js"></script>
<script src="<?= base_url() ?>assets/backend/plugins/custom/prismjs/prismjs.bundle.js"></script>
<script src="<?= base_url() ?>assets/backend/js/scripts.bundle.js"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="<?= base_url() ?>assets/backend/js/func.js"></script>
<script>
   
    function refresh_redirect(time,refresh_page=""){
        if(refresh_page!=""){
            setTimeout(function(){ window.location.href=refresh_page; }, time);
        }else{
            setTimeout(function(){ window.location.reload() }, time);
        }
    }

    function alertToggle(tur,metin1,metin2){
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
        if(tur==1){
            toastr.success(metin1, metin2);
        }else if(tur==2){
            toastr.error(metin1, metin2);
        }else{
            toastr.info(metin1, metin2);
        }

    }

    function alertS(message,icon){
        Swal.fire({
            text: message,
            icon: icon,
            buttonsStyling: false,
            confirmButtonText: "Tamam.",
            customClass: {
                confirmButton: "btn font-weight-bold btn-light confirmAlert"
            }
        }).then(function () {
            KTUtil.scrollTop();
        });
    }

    $( document ).on( 'keypress', '.sadeceFloat', function( e ) {
        if ((event.which != 46 || $(this).val().indexOf(',') != -1) && (event.which < 48 || event.which > 57) ) {
            event.preventDefault();
        }
    });
</script>

<?php

if(!$this->session->userdata("user_one")) {
    $this->load->view($this->viewFolder."/page_script");
}else{
    $this->load->view($view["viewFolder"]."/page_script");
}
 ?>
<script src="<?= base_url() ?>assets/backend/js/pages/widgets.js"></script>
<script src="<?= base_url() ?>assets/backend/js/main_script.js"></script>






