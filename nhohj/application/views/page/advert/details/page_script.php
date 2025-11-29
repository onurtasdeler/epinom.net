<script src="<?= base_url("assets/js/") ?>select2.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="<?= base_url("assets/simplelightbox-master") ?>/dist/simple-lightbox.js?v2.14.0"></script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- Lightbox JS -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<?php

$giris = getLangValue(25);

$profil = getLangValue(31);

?>



<script>

    var swiper = new Swiper(".mySwiper2", {

        spaceBetween: 30,

        centeredSlides: true,

        autoplay: {

            delay: 2500,

            disableOnInteraction: false

        },

        pagination: {

            el: ".swiper-pagination",

            clickable: true

        },

        navigation: {



            nextEl: ".swiper-button-next",

            prevEl: ".swiper-button-prev"

        },

    });







    $(document).on('click', '[data-toggle="lightbox"]', function(event) {

        event.preventDefault();

        $(this).ekkoLightbox();

    });



    function sendPay(){

        $("#satinAlButton").prop("disabled",true);

        

        const inputs = document.querySelectorAll("input[name^='special_field']");

        const data = {};



        inputs.forEach(input => {

            const key = input.name.match(/'(.+?)'/)[1]; // Anahtar kısmını al

            data[key] = input.value; // Değerini ata

        });

        $.post("<?= base_url() ?>create-ad-order", {adsToken:"<?= $uniq->ilanNo ?>",specialField:data}, function (response) {

            if(response.hata=="var"){

                $("#satinAlButton").prop("disabled",false);

                toastr.warning(response.message);

            }else{

                $("#satinAlButton").remove();

                toastr.success(response.message);

                setTimeout(function (){

                    let sendToThere = (response.waiting == 1 ? 'waiting' : 'completed');

                    //window.location.href="<?= base_url(gg().getLangValue(54,"table_pages")->link) ?>?type=" + sendToThere

                },1400);

            }

        });

    }



    function followStore(token){

        <?php

        if(getActiveUsers()){

            if($uniq->user_id==getActiveUsers()->id){

                ?>

                toastr.warning("<?= ($_SESSION["lang"]==1)?"Kendinizi Takip edemezsiniz":"You can't follow yourself" ?>")

                <?php

            }else{

                ?>

                $.post("<?= base_url() ?>follow-store", {token:token,lang:"<?= $_SESSION["lang"] ?>"}, function (response) {

                    if(response) {

                        if(response.hata=="var"){

                            toastr.warning(response.message);

                        }else{

                            $("#takipButton").html("<i class=' fa fa-check'> <?= ($_SESSION["lang"]==1) ?"Takiptesiniz":"Following" ?>");

                            $("#takipButton").css("background-color","green");

                        }

                    }

                });

                <?php

            }

        }else{

        ?>

        toastr.warning("<?= langS(247,2) ?>");

        <?php

        }

        ?>



    }

    (function() {

        var $gallery = new SimpleLightbox('.gallery a', {});

    })();



    $(document).ready(function () {

        $('#shareModal2 #mainCategory').on('change', function (e) {

            var data = $(this).val();

            if(data){

                $.ajax({

                    url: "<?= base_url("get-sms-task") ?>",

                    type: 'POST',

                    data: {veri:data,lang:"<?= $_SESSION["lang"] ?>",store:"<?= $uniq->ilanNo ?>",type:1},

                    success: function (response) {

                        if(response.hata=="yok"){

                            $("#contents").val(response.message);

                        }else{



                        }

                    },

                });

            }else{

                $("#speTitle").hide();

                $("#speCont").html("");

                $("#speTitle").hide();

                $('.selects#topCategory').prop('required',false); // Notify only Select2 of changes

                $('.selects#subCategory').prop('required',false); // Notify only Select2 of changes

                $("#topCategoryCont").fadeOut();

                $("#subCategoryCont").fadeOut();

                $("#price").prop("disabled",true);

                catSelect="";

                $("#price").val("");

                $(".selects#topCategory").html ("");

                $(".selects#subCategory").html ("");

                $('.selects#topCategory').trigger('change.select2'); // Notify only Select2 of changes

                $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes

            }



        });

        $("#smsForm").validate({

            rules: {



                rating:{

                    required:true,

                },



            },

            messages: {

                rating: {

                    minlength: "Lütfen Şablon Seçiniz",

                },



            },

            submitHandler: function (form) {

                var formData = new FormData(document.getElementById("smsForm"));

                $("#submitButtons").prop("disabled", true);

                $("#submitButtons").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");

                $.ajax({

                    url: "<?= base_url("get-sms-task") ?>",

                    type: 'POST',

                    data: formData,

                    success: function (response) {

                        if (response) {

                            if (response.hata == "var") {

                                toastr.warning(response.message);

                                $("#uyCont .alert").removeClass("alert-success").addClass("alert-warning");

                                $("#uyCont .alert").html(response.message);

                                $("#uyCont").fadeIn(200);

                                $("#submitButtons").prop("disabled", false);

                                $("#submitButtons").html("<i class='fa fa-check'></i> <?= langS(257, 2) ?>");

                            } else {

                                $(".deleted").remove();

                                $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");

                                $("#uyCont .alert").html(response.message);

                                $("#uyCont").fadeIn(500);

                                toastr.success(response.message);

                                $("#submitButtons").prop("disabled", false);

                                $("#submitButtons").html("<i class='fa fa-check'></i> <?= langS(257, 2) ?>");

                                setTimeout(function () {

                                    window.location.reload();

                                }, 2000);

                            }

                        } else {

                            toastr.warning("Ağınızda beklenmedik bir hata meydana geldi. Lütfen tekrar deneyiniz");

                        }

                    },

                    cache: false,

                    contentType: false,

                    processData: false

                });

            }});



        $("#messageForm").validate({

            rules: {



            },

            messages: {



            },

            submitHandler: function (form) {

                var formData = new FormData(document.getElementById("messageForm"));

                $("#submitButtons").prop("disabled",true);

                $("#submitButtons").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14,2) ?>");

                $.ajax({

                    url: "<?= base_url("send-new-message") ?>",

                    type: 'POST',

                    data: formData,

                    success: function (response) {

                        if(response){

                            if(response.hata=="var"){

                                toastr.warning(response.message);

                                $("#uyCont .alert").removeClass("alert-success").addClass("alert-warning");

                                $("#uyCont .alert").html(response.message);

                                $("#uyCont").fadeIn(200);

                                $("#submitButtons").prop("disabled",false);

                                $("#submitButtons").html("<i class='fa fa-check'></i> <?= langS(257,2) ?>");

                            }else{

                                $(".deleted").remove();

                                $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");

                                $("#uyCont .alert").html(response.message);

                                $("#uyCont").fadeIn(500);

                                toastr.success(response.message);

                                $("#submitButtons").prop("disabled",false);

                                $("#submitButtons").html("<i class='fa fa-check'></i> <?= langS(257,2) ?>");

                                setTimeout(function (){

                                    window.location.reload();

                                },2000);

                            }

                        }else{

                            toastr.warning("Ağınızda beklenmedik bir hata meydana geldi. Lütfen tekrar deneyiniz");

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

