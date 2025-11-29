<script>
    $('input[type=radio][name=balance]').change(function() {
        if (this.value == '1') {
            $(".bottom-box").fadeIn(600);
        }
        else if (this.value == '2') {
            $(".bottom-box").fadeIn(600);
        }else{
            $(".bottom-box").fadeOut(600);
        }
    });

    var body = $("html, body");
    body.stop().animate({scrollTop:330}, 300, 'swing', function() {
    });

    $("#payForm").on("submit",function (e){
        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url:"<?= base_url("pay-form-submit") ?>",
            type: 'POST',
            data: formData,
            success: function (response) {
                $("#payForm").hide(600);
                $(".payment-content").append(response);
            },
            cache: false,
            contentType: false,
            processData: false
        });

    });
    
    $(document).ready(function() {
        $("#main-menu-43").on("click", function() {
            $("#submenu-43").toggle();
        });
    });
</script>