<script src="<?= base_url() ?>assets/js/vendor/jquery.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/jquery-ui.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/modernizer.min.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/feather.min.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/slick.min.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/bootstrap.min.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/sal.min.js"></script>

<!--<script src="<?= base_url() ?>assets/js/vendor/particles.js"></script>-->

<script src="<?= base_url() ?>assets/js/vendor/jquery.style.swicher.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/js.cookie.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/count-down.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/isotop.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/imageloaded.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/backtoTop.js"></script>

<!--<script src="<?= base_url() ?>assets/js/vendor/odometer.js"></script>-->

<script src="<?= base_url() ?>assets/js/vendor/jquery-appear.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/scrolltrigger.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/jquery.custom-file-input.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/savePopup.js"></script>

<script src="<?= base_url() ?>assets/js/vendor/vanilla.tilt.js"></script>

<script src="<?= base_url() ?>assets/datatables/datatables.bundle.js"></script>



<!-- main JS -->

<script src="<?= base_url() ?>assets/js/main.js<?= "?v=" . rand(123123, 1685168) ?>"></script>

<!-- Meta Mask  -->

<script src="<?= base_url() ?>assets/js/vendor/web3.min.js"></script>

<script src="<?= base_url() ?>assets/js/jquery.lazyload.js"></script>

<script src="<?= base_url() ?>assets/js/toastr/toastr.min.js"></script>

<script type="text/javascript" charset="utf-8">
    toastr.options = {

        "closeButton": false,

        "debug": false,

        "newestOnTop": false,

        "progressBar": true,

        "positionClass": "toast-top-right",

        "preventDuplicates": false,

        "onclick": null,

        "showDuration": "300",

        "hideDuration": "1000",

        "timeOut": "4000",

        "extendedTimeOut": "1000",

        "showEasing": "swing",

        "hideEasing": "linear",

        "showMethod": "fadeIn",

        "hideMethod": "fadeOut"

    }

    function git(url) {

        window.location.href = url;

    }



    <?php

    if ($this->viewFolder == "page/basket") {

    ?>

        var timer;

        function stopTimer() {

            clearInterval(timer);

        }

        function startTimer() {

            timer = setInterval(function() {

                $.ajax({

                    url: '<?= base_url("update-basket-card") ?>',

                    method: 'POST',

                    data: {
                        token: 1
                    },

                    success: function(response) {

                        if (response.degisen) {

                            $("body").append(response.degisen)

                            $("#basketCount").html(response.total);

                        } else {

                            $("#basketCount").html(response.total);

                        }

                    },

                    cache: false,

                });

            }, 5000); // 3000 milisaniye = 3 saniye

        }

    <?php

    }

    ?>





    $(document).ready(function() {

        <?php

        if ($this->viewFolder == "page/basket") {

        ?>

            startTimer();

        <?php

        }

        ?>



    });



    var minLength = 14;

    var maxLength = 14;

    $('.phone').keypress(function(e) {

        var charCode = (e.which) ? e.which : event.keyCode

        if (String.fromCharCode(charCode).match(/[^0-9]/g))

            return false;

    });

    $('.phone').on('keydown keyup change', function() {

        var char = $(this).val();

        var charLength = $(this).val().length;

        if (charLength == 2 && char == "(0") {

            $(this).val("(");

        }

        if (charLength < minLength) {

            $('#warning-message').text('Length is short, minimum ' + minLength + ' required.');

        } else if (charLength > maxLength) {

            $('#warning-message').text('Length is not valid, maximum ' + maxLength + ' allowed.');

            $(this).val(char.substring(0, maxLength));

        } else {

            $('#warning-message').text('');

        }

    });

    $('.phone').bind('paste', function(e) {

        setTimeout(function() {

            $('#phone').trigger('autocomplete');
        }, 0);

    });

    $('.phone').keydown(function(e) {



        var key = e.which || e.charCode || e.keyCode || 0;



        $phone = $(this);

        // Don't let them remove the starting '('

        if ($phone.val().length === 1 && (key === 8 || key === 46)) {



            $phone.val('(');

            return false;

        }

        // Reset if they highlight and type over first char.
        else if ($phone.val().charAt(0) !== '(') {



            $phone.val('(' + String.fromCharCode(e.keyCode) + '');

        }



        // Auto-format- do not expose the mask as the user begins to type

        if (key !== 8 && key !== 9) {

            if ($phone.val().length === 4) {

                $phone.val($phone.val() + ')');

            }

            if ($phone.val().length === 5) {

                $phone.val($phone.val() + ' ');

            }

            if ($phone.val().length === 9) {

                $phone.val($phone.val() + '-');

            }

        }



        // Allow numeric (and tab, backspace, delete) keys only

        return (key == 8 || key == 9 || key == 46 || (key >= 48 && key <= 57) || (key >= 96 && key <= 105));

    }).bind('focus click',

        function() {

            $phone = $(this);

            if ($phone.val().length === 0) {

                $phone.val('(');

            } else {

                var val = $phone.val();

                $phone.val('').val(val); // Ensure cursor remains at the end

            }

        }).blur(function() {

        $phone = $(this);

        if ($phone.val() === '(') {

            $phone.val('');

        }

    });



    $(document).ready(function() {

        $('a[href*="#"]').on('click', function(e) {

            e.preventDefault();



            $('html, body').animate({

                scrollTop: $($(this).attr('href')).offset().top

            }, 500, 'linear');

        });
    });

    function loadTabContent(catId, subCatId) {
        $.ajax({
            url: '<?= base_url("get-tab-content") ?>',
            method: 'POST',
            data: {
                catId: catId,
                subCatId: subCatId
            },
            success: function(response) {
                $("#category_" + catId).html(response);
                $(".btn-tab-" + catId).removeClass("btn-tab-active");
                $(".btn-tab_m-" + catId).removeClass("btn-tab-active");
                $("#tab_" + catId + "_" + subCatId).addClass("btn-tab-active");
                $("#tab_m_" + catId + "_" + subCatId).addClass("btn-tab-active");
            },
        });
    }
    
    function runTabContent(){
        $(".btn-tab-active").click();
    }

    runTabContent();
</script>