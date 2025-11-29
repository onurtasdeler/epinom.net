<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>

<!--end::Page Vendors-->

<script>



    $(document).ready(function() {



        $("#guncelleForm").on("submit", function(e) {

            e.preventDefault();

            


            var formData = new FormData(this);

            $.ajax({

                url: "<?= base_url("settings-update/streamlabs") ?>",

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