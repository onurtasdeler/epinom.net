<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.7/js/dataTables.checkboxes.min.js"></script>

<script>
    $(document).ready(function (){
        $("#markaAddForm").validate({
            rules: {
                sifre: {

                    minlength: 8,
                },
                sifre_tekrar: {

                    minlength: 8,
                    equalTo: "#sifre"
                }
            },
            messages: {
                sifre: {
                    minlength: "Şifreniz en az 8 karakter olmalıdır",
                    required: "Lütfen Yeni Şifrenizi Giriniz",
                } ,
                sifre_tekrar: {
                    required: "Lütfen Yeni Şifrenizi Giriniz",
                    minlength: "Şifreniz en az 8 karakter olmalıdır",
                    equalTo :"Şifreler birbiriyle uyuşmuyor"
                }

            },
            submitHandler: function (form) {

                var formData = new FormData(document.getElementById("markaAddForm"));
                $.ajax({
                    url: "<?= base_url("sifre-degistir") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.err) {
                                als(response.message, "warning");
                            } else {
                                als(response.message, "success");
                                setTimeout(function (){
                                   window.location.href="<?= base_url("exit") ?>";
                                },500);
                            }
                        } else {
                            als("API'de hata meydana geldi !", "danger");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });


    })
</script>