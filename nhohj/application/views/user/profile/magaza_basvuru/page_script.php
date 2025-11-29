<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    <?php $user = getActiveUsers(); ?>
    $(document).ready(function () {
        $("#fatima").change(function () {
            var ext = $(this).val().split('.').pop();
            if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {
                if (this.files[0].size > 2000000) {
                    toastr.warning("<?= langS(58, 2) ?>")
                } else {
                    $("#profileImageLabel").html();
                }
            } else {
                toastr.warning("<?= langS(75, 2) ?>")
            }
        });

        $("#nipa").change(function () {
            var ext = $(this).val().split('.').pop();
            if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {
                if (this.files[0].size > 2000000) {
                    toastr.warning("<?= langS(58, 2) ?>")
                } else {
                    $("#profileImageLabel").html();
                }
            } else {
                toastr.warning("<?= langS(75, 2) ?>")
            }
        });



        $("#profileUpdateForm").validate({
            rules: {

            },
            messages: {

            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("profileUpdateForm"));
                $("#submitButton").prop("disabled", true);
                $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");
                $.ajax({
                    url: "<?= base_url("set-store-app") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                if (response.type == "validation") {
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    $("#submitButton").prop("disabled", false);
                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= ($user->is_magaza==1)?langS(72,2):langS(57,2)     ?>");
                                } else {
                                    toastr.warning(response.message);
                                    $("#submitButton").prop("disabled", false);
                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= ($user->is_magaza==1)?langS(72,2):langS(57,2)     ?>");
                                }
                            } else {
                                $(".deleted").remove();
                                $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");
                                $("#uyCont .alert").html(response.message);
                                $("#uyCont").fadeIn(500);
                                $("#submitButton").remove();
                                toastr.success(response.message);
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            }
                        } else {
                            toastr.warning("<?=langS(22,2)  ?>");
                            $("#submitButton").prop("disabled", false);
                            $("#submitButton").html("<i class='fa fa-check'></i> <?= langS(57,2) ?>");
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });

            }
        });

    });
</script>