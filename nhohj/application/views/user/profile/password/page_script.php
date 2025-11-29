<?php
$giris=getLangValue(25);
$uniql=getLangValue($uniq->id,"table_pages");

?>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
    <?php $user=getActiveUsers(); ?>

    $(document).ready(function (){
        $("#passUpdateForm").validate({
            rules: {
                password: {
                    minlength: 8,
                },
                passTry: {
                    minlength: 8,
                    equalTo: "#password"
                }
            },
            messages: {
                password: {
                    minlength: "<?= langS(11) ?>",
                },
                passTry: {
                    minlength: "<?= langS(11) ?>",
                    equalTo: "<?= langS(10) ?>"
                },

            },
            submitHandler: function (form) {
                var formData = new FormData(document.getElementById("passUpdateForm"));
                $("#submitButton").prop("disabled", true);
                $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");
                $.ajax({
                    url: "<?= base_url("profile-pass-update") ?>",
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response) {
                            if (response.hata == "var") {
                                if (response.type == "validation") {
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    $("#submitButton").prop("disabled", false);
                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= $uniql->titleh1     ?>");
                                } else {
                                    if(response.message=="oturum"){
                                        window.location.reload();
                                    }else{
                                        toastr.warning(response.message);
                                        $("#submitButton").prop("disabled", false);
                                        $("#submitButton").html("<i class='fa fa-check'></i> <?=  $uniql->titleh1    ?>");
                                    }

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
                                }, 3000);
                            }
                        } else {
                            toastr.warning("<?=langS(22,2)  ?>");
                            $("#submitButton").prop("disabled", false);
                            $("#submitButton").html("<i class='fa fa-check'></i> <?=  $uniql->titleh1 ?>");
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