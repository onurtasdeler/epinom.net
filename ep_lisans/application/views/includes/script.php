<script src="<?= base_url("assets/") ?>assets/js/bundle.js?ver=3.1.0"></script>
<script src="<?= base_url("assets/") ?>assets/js/scripts.js?ver=3.1.0"></script>
<script src="<?= base_url("assets/") ?>assets/js/charts/chart-analytics.js?ver=3.1.0"></script>
<script src="<?= base_url("assets/") ?>assets/js/libs/jqvmap.js?ver=3.1.0"></script>
<script src="<?= base_url("assets/") ?>assets/js/charts/chart-ecommerce.js?ver=3.1.0"></script>
<script src="<?= base_url("assets/") ?>assets/js/charts/chart-widgets.js?ver=3.1.0"></script>
<script src="<?= base_url("assets/") ?>js/example-toastr.js?ver=3.1.0"></script>

<script>
    function als(metin,tur,pos="top-right"){
        NioApp.Toast(metin, tur, {position: pos});
    }
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
    $('.phone').keydown(function (e) {

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
    });
</script>