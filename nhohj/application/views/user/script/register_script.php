<?php
$getLang=getLangValue(25,"table_pages");
?>
<script>
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
        "timeOut": "3000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $(document).ready(function () {

        $("#registerForm").on("submit",function (e){
            e.preventDefault();
            $("#subb").prop("disabled",true);
            $("#subb").html("<?= langS(347,2) ?>");

            var formData = new FormData(this);
            $.ajax({
                url:"<?= base_url() ?>user-register",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if(response.errorr=="yok"){
                        if(response.tur){

                            $("#hatas").html(response.message);
                            $("#hatas").fadeIn(400);
                            $(".fxt-form").fadeOut(100);
                            $(".fxt-form").remove();
                            //setTimeout(function(){ window.location.href="<?= base_url(gg().$getLang->link) ?>" }, 2000);
                        }else{
                            $("#hatas").html(response.message);
                            $("#hatas").fadeIn(400);
                            $("#subb").remove();
                            toastr.success("<?= str_replace("\r\n","",langS(110,2)) ?>");
                            setTimeout(function(){ window.location.href="<?= base_url(gg().$getLang->link) ?>" }, 2000);
                        }
                    }else{
                        $("#subb").prop("disabled",false);
                        $("#subb").html("<?= langS(10,2) ?>");
                        if(response.errorr=="hata"){
                            $("#hatas").html(response.message);
                            $("#hatas").fadeIn(400);
                            toastr.warning(response.message);
                        }else{
                            var result = $(response.message).text().split('\n');
                            for(var i=0;i<result.length;i++){
                                toastr.warning(result[i]);
                            }
                        }
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });

        var minLength = 14;
        var maxLength = 14;
        $('.phone').keypress(function (e) {
            var charCode = (e.which) ? e.which : event.keyCode
            if (String.fromCharCode(charCode).match(/[^0-9]/g))
                return false;
        });
        $('.phone').on('keydown keyup change', function(){
            var char = $(this).val();
            var charLength = $(this).val().length;
            if(charLength==2 && char=="(0"){
                $(this).val("(");
            }
            if(charLength < minLength){
                $('#warning-message').text('Length is short, minimum '+minLength+' required.');
            }else if(charLength > maxLength){
                $('#warning-message').text('Length is not valid, maximum '+maxLength+' allowed.');
                $(this).val(char.substring(0, maxLength));
            }else{
                $('#warning-message').text('');
            }
        });
        $('.phone').bind('paste', function(e) {
            setTimeout(function() {
                $('#phone').trigger('autocomplete');}, 0);
        });
        /*$('.phone').keydown(function (e) {

            var key = e.which || e.charCode || e.keyCode || 0;

            $phone = $(this);
            // Don't let them remove the starting '('
            if ($phone.val().length === 1  && (key === 8 || key === 46  )) {

                $phone.val('(');
                return false;
            }
            // Reset if they highlight and type over first char.
            else if ($phone.val().charAt(0) !== '(') {

                $phone.val('('+String.fromCharCode(e.keyCode)+'');
            }

            // Auto-format- do not expose the mask as the user begins to type
            if (key !== 8 && key !== 9 ) {
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
            function (){
                $phone = $(this);
                if ($phone.val().length === 0) {
                    $phone.val('(');
                }
                else {
                    var val = $phone.val();
                    $phone.val('').val(val); // Ensure cursor remains at the end
                }
            }).blur(function () {
            $phone = $(this);
            if ($phone.val() === '(') {
                $phone.val('');
            }
        });*/
    });



    $(function(){
        $('.onlyTxt').keypress(function (e) {
            var regex = /^[a-züöçğşıİÜĞÇŞÖ\s]+$/i;
            var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
            if (regex.test(str)) {
                return true;
            }
            else
            {
                e.preventDefault();
                return false;
            }
        });
        $("#name").bind("cut copy paste", function(){
            return false;
        });
        $("#phone").bind("cut copy paste", function(){
            return false;
        });
        $("#email").bind("cut copy paste", function(){
            return false;
        });
    });


</script>