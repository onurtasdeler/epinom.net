<?php
    if($this->session->flashdata('login_successful_toast')){
?>
    <script>
        window.onload = function(){
            const FLASHTOAST = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: function(toast) {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
            FLASHTOAST.fire({
                icon: 'success',
                title: 'Başarıyla giriş yapıldı!'
            });
        }
    </script>
<?php
    }
    if($this->session->flashdata('login_activate_successful_toast')){
?>
    <script>
        window.onload = function(){
            const FLASHTOAST = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: function(toast) {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
            FLASHTOAST.fire({
                icon: 'success',
                title: 'Başarıyla giriş yapıldı ve hesabınız aktifleştirildi!'
            });
        }
    </script>
<?php
    }
?>