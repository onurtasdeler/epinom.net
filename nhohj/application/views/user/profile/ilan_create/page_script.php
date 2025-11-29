<script src="<?= base_url("assets/js/") ?>select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="<?= base_url() ?>assets/tinymce/tinymce.bundle.js"></script>

<script src="<?= base_url() ?>assets/tinymce/tinymce.js"></script>



<script>

    function getCategoryDefaultImages(e) {

        if (e.target.value) {

            let catId = e.target.value;

            $.ajax({

                url: "<?= base_url("get-category-default-images") ?>",

                type: 'POST',

                data: {

                    catId: catId,

                },

                success: function(response) {

                    $("#default_image_list").html("");

                    if (response.count == 0){

                        $("#default_image_list").html("<small>Seçilen kategoriye ait hazır görsel bulunmamaktadır.</small>");

                    }

                    let htmlTemplate = '<div class="col-md-4"><div class="profile-left col-lg-12"><div class="profile-image mb--30"> <h6 class="title">Varsayılan Görsel --number--<br><small style="font-size:12px; font-weight: 300">Seçmek için görsele tıklayabilirsiniz.</small></h6><img data-id="--imgid--" onclick="select_default_image(event);" src="--url--" class="default_images default-hover-opacity-85"> </div></div></div>';

                    response.forEach((item, key) =>{

                        let default_item = htmlTemplate.replace("--number--", key+1);

                        default_item = default_item.replace("--url--", "<?=base_url();?>/upload/ilanlar/default/" + item.image);

                        default_item = default_item.replace("--imgid--", item.id);

                        $("#default_image_list").append(default_item)

                    });

                },

            });

        }

    }



    function select_default_image(e){

        $(".default_images").removeClass("default-opacity-100");

        $(".default_images").addClass("default-opacity-55");

        $(e.target).removeClass("default-opacity-55");

        $(e.target).addClass("default-opacity-100");

        $("#selected_default_image").val(e.target.dataset.id);
        

    }

</script>



<script>

    var themes = "";

    var skin = "";

    if ($("body").hasClass("active-light-mode")) {

        themes = "";

        skin = "oxide-dark";

    } else {

        themes = "dark";

        skin = "oxide-dark";

    }

    var catSelect = "";

    tinymce.init({

        selector: 'textarea#icerik_en',

        language: 'en',

        height: "400",

        cleanup: false,

        statusbar: false,

        menubar: false,

        toolbar: ['  ',

            ' bold italic | alignleft aligncenter  | forecolor backcolor',

            'bullist numlist |  indent |      '

        ],

        plugins: 'advlist  lists textcolor ',

        skin: skin,

        content_css: themes



    });

    tinymce.init({

        selector: 'textarea#icerik_tr',

        language_url: '<?= base_url("assets/tinymce/") ?>tr.js',

        language: 'tr',

        height: "400",

        cleanup: false,

        statusbar: false,

        menubar: false,

        toolbar: ['  ',

            ' bold italic | alignleft aligncenter  | forecolor backcolor',

            'bullist numlist |  indent |      '

        ],

        plugins: 'advlist  lists textcolor ',

        skin: skin,

        content_css: themes

    });

    $(function() {



        $(".selects#mainCategory").select2({});

        $(".selectss").select2({});

        $(".selects#topCategory").select2({});

        $(".selects#subCategory").select2({});

        $('.selects#mainCategory').on('select2:select', function(e) {

            var data = e.params.data;

            if (data.id) {

                $.ajax({

                    url: "<?= base_url("get-category-top-list") ?>",

                    type: 'POST',

                    data: {

                        veri: data.id,

                        lang: "<?= $_SESSION["lang"] ?>",

                        t: 1

                    },

                    success: function(response) {

                        if (response.veri == "yok") {

                            $(".selects#topCategory").html("").hide("");

                            $('.selects#topCategory').trigger('change.select2'); // Notify only Select2 of changes

                            $('.selects#topCategory').prop('required', true); // Notify only Select2 of changes

                            $('.selects#subCategory').prop('required', true); // Notify only Select2 of changes

                            $("#topCategoryCont").fadeOut(300);

                            $(".selects#subCategory").html("").hide("");

                            $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes

                            $("#subCategoryCont").fadeOut(300);

                            $("#speTitle").hide();

                            $("#speCont").html("");

                            $("#speTitle").hide();

                            $("#price").prop("disabled", false);

                            catSelect = "1";

                            if (response.spe) {

                                $("#speCont").html(response.spe).fadeIn(300);

                                $("#speCont .selectss").select2({});

                                $("#speTitle").fadeIn(200);

                            } else {

                                $("#speTitle").hide();

                                $("#speCont").html("");

                                $("#speTitle").hide();

                            }

                        } else {

                            if (response.spe) {

                                $("#speCont").html(response.spe).fadeIn(300);

                                $("#speCont .selectss").select2({});

                                $("#speTitle").fadeIn(200);

                            } else {

                                $("#speTitle").hide();

                                $("#speCont").html("");

                                $("#speTitle").hide();

                            }

                            $("#topCategoryCont").fadeIn(300);

                            $(".selects#topCategory").html(response.veri);

                            $('.selects#topCategory').prop('required', true); // Notify only Select2 of changes

                            $('.selects#topCategory').trigger('change.select2'); // Notify only Select2 of changes

                            catSelect = "";

                            $("#price").prop("disabled", true);

                            $("#price").val("");

                        }

                    },

                });

            } else {

                $("#speTitle").hide();

                $("#speCont").html("");

                $("#speTitle").hide();

                $('.selects#topCategory').prop('required', false); // Notify only Select2 of changes

                $('.selects#subCategory').prop('required', false); // Notify only Select2 of changes

                $("#topCategoryCont").fadeOut();

                $("#subCategoryCont").fadeOut();

                $("#price").prop("disabled", true);

                catSelect = "";

                $("#price").val("");

                $(".selects#topCategory").html("");

                $(".selects#subCategory").html("");

                $('.selects#topCategory').trigger('change.select2'); // Notify only Select2 of changes

                $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes

            }



        });

        $('.selects#topCategory').on('select2:select', function(e) {

            var data = e.params.data;

            if (data.id) {

                $.ajax({

                    url: "<?= base_url("get-category-top-list?t=1") ?>",

                    type: 'POST',

                    data: {

                        veri: data.id,

                        lang: "<?= $_SESSION["lang"] ?>",

                        t: 1

                    },

                    success: function(response) {

                        if (response.veri == "yok") {



                            $('.selects#subCategory').prop('required', false); // Notify only Select2 of changes

                            $(".selects#subCategory").html("").hide("");

                            $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes

                            $("#subCategoryCont").fadeOut(300);

                            $("#speTitle").hide();

                            $("#speCont").html("");

                            $("#speTitle").hide();

                            $("#price").prop("disabled", false);

                            catSelect = "1";

                            if (response.spe) {

                                $("#speCont").html(response.spe).fadeIn(300);

                                $("#speCont .selectss").select2({});

                                $("#speTitle").fadeIn(200);

                            } else {

                                $("#speTitle").hide();

                                $("#speCont").html("");

                                $("#speTitle").hide();

                            }

                        } else {

                            if (response.spe) {

                                $("#speCont").html(response.spe).fadeIn(300);

                                $("#speCont .selectss").select2({});

                                $("#speTitle").fadeIn(200);

                            } else {

                                $("#speTitle").hide();

                                $("#speCont").html("");

                                $("#speTitle").hide();

                            }

                            catSelect = "";

                            $("#price").prop("disabled", true);

                            $("#price").val("");

                            $('.selects#subCategory').prop('required', true); // Notify only Select2 of changes

                            $("#subCategoryCont").fadeIn(300);

                            $(".selects#subCategory").html(response.veri);

                            $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes



                        }

                    },

                });

            } else {

                $("#price").prop("disabled", true);

                catSelect = "";

                $('.selects#subCategory').prop('required', false); // Notify only Select2 of changes

                $("#subCategoryCont").fadeOut(300);

                $(".selects#subCategory").html("");

                $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes

                $("#price").val("");

            }



        })

        $('.selects#subCategory').on('select2:select', function(e) {

            var data = e.params.data;

            if (data.id) {

                $("#price").prop("disabled", false);

                catSelect = "1";

            } else {

                $("#price").prop("disabled", true);

                catSelect = "";

                $("#price").val("");

            }



        });



    });







    <?php $user = getActiveUsers(); ?>

    $(document).ready(function() {

        var saySpecialTable = 1;



        $('#addSpecialFieldTable').on('click', '.deleteS', function() {

            var rowIndex = $(this).closest('tr').index(); // Silinecek satırın sırasını al

            $(this).closest('tr').remove();

        });



        $("#add_row_special").on("click", function(e) {

            if ($("#special_field").val() && $("#special_field").val().length < 200) {

                var str = $("#special_field").val();

                if (str != "") {

                    $("#addSpecialFieldTable").append("<tr id='add-special-" + saySpecialTable + "'><td>" + str + "<input type='hidden' value='" + str + "' name='special_field[]<'></td><td style='padding: 5px !important;vertical-align: middle;text-align: center;'><button  type='button'  class='btn deleteS btn-sm btn-danger'><i class='fa fa-trash'></i></button></td></tr>");

                    saySpecialTable++;

                    $("#special_field").val("");

                } else {

                    $("#special_field").val("");

                }



            } else {

                if ($("#special_field").val().length > 200) {

                    toastr.warning("<?= ($_SESSION["lang"] == 1) ? "Özel Alan Adı Çok Uzun." : "Custom Field Name Too Long." ?>");

                } else {

                    toastr.warning("<?= ($_SESSION["lang"] == 1) ? "Lütfen Özel Alan Adı Giriniz" : "Please enter custom field name." ?>");

                }

            }

        });





        $("#price").on("change keyup click", function() {

            if (catSelect != "") {

                if ($("#price").val()) {

                    if ($("#price").val() > 0) {

                        $.ajax({

                            url: "<?= base_url("get-price-no-stock-com") ?>",

                            type: 'POST',

                            data: {

                                price: $("#price").val(),

                                main: $("#mainCategory").val(),

                                top: $("#topCategory").val(),

                                sub: $("#subCategory").val(),

                                lang: "<?= $_SESSION["lang"] ?>",

                                t: 1,

                            },

                            success: function(response) {

                                if (response.hata) {



                                } else {

                                    $("#unitprice").html(response.unit);

                                    if (response.komisyon_oran) {

                                        $("#komOran").html(response.komisyon_oran);

                                        $("#komamount").html(response.komisyon);

                                        $("#cash").html(response.cash);

                                    } else {

                                        $("#komamount").html(response.komisyon);

                                        $("#cash").html(response.cash);

                                    }

                                }

                            },

                        });

                    } else {

                        $("#price").val("");

                        $("#komamount").html("-");

                        $("#unitprice").html("-");

                        $("#cash").html("-");

                        $("#komOran").html("<?= ($user->magaza_ozel_komisyon != 0) ? "%" . $user->magaza_ozel_komisyon . " <small class='text-warning'>(" . langS(91, 2) . ")</small>" : "-" ?>");

                        ("#cash").html("-");

                    }

                } else {

                    $("#komamount").html("-");

                    $("#unitprice").html("-");

                    $("#cash").html("-");

                    $("#komOran").html("<?= ($user->magaza_ozel_komisyon != 0) ? "%" . $user->magaza_ozel_komisyon . " <small class='text-warning'>(" . langS(91, 2) . ")</small>" : "-" ?>");

                    ("#cash").html("-");

                }

            } else {

                $("#price").val("");

                $("#price").prop("disabled", true);

            }

        });





        $("#fatima").change(function() {

            var ext = $(this).val().split('.').pop();

            if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {

                if (this.files[0].size > 2000000) {

                    toastr.warning("<?= langS(58, 2) ?>")

                    $("#rbtinput1").attr("src", "<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");

                } else {

                    $("#profileImageLabel").html();

                }

            } else {

                toastr.warning("<?= langS(75, 2) ?>");

                $("#rbtinput1").attr("src", "<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");

            }

        });



        $("#nipa").change(function() {

            var ext = $(this).val().split('.').pop();

            if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {

                if (this.files[0].size > 2000000) {

                    toastr.warning("<?= langS(58, 2) ?>")

                    $("#rbtinput2").attr("src", "<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");

                } else {

                    $("#profileImageLabel").html();

                }

            } else {

                toastr.warning("<?= langS(75, 2) ?>");

                $("#rbtinput2").attr("src", "<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");

            }

        });



        $("#nipa2").change(function() {

            var ext = $(this).val().split('.').pop();

            if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {

                if (this.files[0].size > 2000000) {

                    toastr.warning("<?= langS(58, 2) ?>")

                    $("#rbtinput3").attr("src", "<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");

                } else {

                    $("#profileImageLabel").html();

                }

            } else {

                toastr.warning("<?= langS(75, 2) ?>");

                $("#rbtinput3").attr("src", "<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");

            }

        });





        $("#ilanCreateForm").validate({

            rules: {



            },

            messages: {



            },

            submitHandler: function(form) {

                var formData = new FormData(document.getElementById("ilanCreateForm"));

                $("#submitButton").prop("disabled", true);

                $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");

                $.ajax({

                    url: "<?= base_url("create-ads-no-stock") ?>",

                    type: 'POST',

                    data: formData,

                    success: function(response) {

                        if (response) {

                            if (response.hata == "var") {

                                if (response.type == "valid") {

                                    $("#uyCont .alert").html(response.message);

                                    $("#uyCont").fadeIn(500);

                                    $("#submitButton").prop("disabled", false);

                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= ($user->is_magaza == 1) ? langS(89, 2) : langS(89, 2)     ?>");

                                } else if (response.type == "oturum") {

                                    window.location.reload();

                                } else if (response.type == "limit") {

                                    $("#uyCont .alert").html("<?= langS(390, 2) ?>");

                                    $("#uyCont").fadeIn(500);

                                    $("#submitButton").prop("disabled", false);

                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= ($user->is_magaza == 1) ? langS(89, 2) : langS(89, 2)     ?>");

                                    toastr.warning("<?= langS(390, 2) ?>");

                                } else {

                                    toastr.warning(response.message);

                                    $("#submitButton").prop("disabled", false);

                                    $("#submitButton").html("<i class='fa fa-check'></i> <?= ($user->is_magaza == 1) ? langS(89, 2) : langS(89, 2)     ?>");

                                }

                            } else {

                                $(".deleted").remove();

                                $("#uyCont .alert").removeClass("alert-danger").addClass("alert-success");

                                $("#uyCont .alert").html(response.message);

                                $("#uyCont").fadeIn(500);

                                $("#submitButton").remove();

                                toastr.success(response.message);

                                setTimeout(function() {

                                    window.location.href = "<?= base_url("ilanlarim") ?>";

                                }, 2000);

                            }

                        } else {

                            window.location.reload();

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