<script src="<?= base_url("assets/js/") ?>jquery.mask.js" type="text/javascript"></script>
<script src="https://www.paytr.com/js/iframeResizer.min.js"></script>

<script>
    function copyToClipboard(kod) {

        let modifiedKod = kod.replace(/<br\s*\/?>/gi, '\n');
        navigator.clipboard.writeText(modifiedKod);
        // Düzeltilmiş metni panoya kopyala
        toastr.success("<?=  langS(238,2) ?>")
    }
    $(document).ready(function (){
        $('.custom-control-input').change(function() {
            // Tüm 'cusbankradio' divlerini varsayılan arkaplan rengine döndür
            $('.cusbankradio').css('background-color', ''); // Varsayılan arkaplan rengi

            // Seçilen radio butonunun üst divinin arkaplan rengini değiştir
            if ($(this).is(':checked')) {
                $(this).closest('.cusbankradio').css('background-color', '#14141c'); // Değiştirilecek arkaplan rengi
                $('.extra-content').slideUp();

                // Eğer bu radio seçiliyse, ilgili içeriği aç
                if ($(this).is(':checked')) {
                    var extraContent = $(this).siblings('.extra-content');

                    extraContent.slideDown();
                }
            }
        });
        <?php
        if(getActiveUsers()->full_name==""){
            ?>
            $("#verifyInfo").on("click",function (){
                if($("#name").val() && $("#surname").val()){
                    $("#verifyInfo").prop("disabled",true);
                    $.ajax({
                        url: "<?= base_url() ?>set-name-verify",
                        type: 'POST',
                        data: {name:$("#name").val(),surname:$("#surname").val()},
                        success: function (response) {
                            if (response) {
                                if (response.hata == "var") {
                                    if (response.type=="validation") {
                                        $("#uyCont .alert").html(response.message);
                                        $("#uyCont").fadeIn(500);
                                        $("#verifyInfo").prop("disabled",false);
                                        toastr.warning(response.message);
                                    } else {
                                        $("#uyCont .alert").html(response.message);
                                        $("#uyCont").fadeIn(500);
                                        $("#verifyInfo").prop("disabled",false);
                                        toastr.warning(response.message);
                                    }
                                } else {
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont .alert").removeClass("alert-warning").addClass("alert-success");
                                    $("#uyCont").fadeIn(500);
                                    toastr.success(response.message);
                                    $("#verifyInfo").remove();
                                    setTimeout(function (){
                                        window.location.reload();
                                    },1500);
                                }
                            }
                        },
                    });
                }else{
                    toastr.warning("Lütfen bilgilerinizi kontrol ediniz");
                }
            });
            <?php
        }
        ?>

        $('#name').on('input', function() {
            var inputValue = $(this).val();
            var filteredValue = inputValue.replace(/[^a-zA-ZğüşıöçĞÜŞİÖÇ\s]/g, '');

            $(this).val(filteredValue);
        });
        $('#surname').on('input', function() {
            var soyad = $(this).val();

            if (/^[a-zA-ZğüşıöçĞÜŞİÖÇ]*$/.test(soyad)) {
                // Geçerli giriş
            } else {

                $(this).val(soyad.replace(/[^a-zA-ZğüşıöçĞÜŞİÖÇ]+/g, ''));
            }
        });
        $( ".txtOnly" ).keypress(function(e) {
            var key = e.keyCode;
            if (key >= 48 && key <= 57) {
                e.preventDefault();
            }
        });
        $('.floats').keypress(function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        $('.float-number').keypress(function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        $("#payFormNames").on("submit",function(){

            if($("#soyad").val() && $("#ad").val()){
                $.ajax({
                    url:"<?= base_url("pay-update-set-name") ?>",
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        if(response.error){
                            if(response.error=="oturum"){
                                window.location.href="<?= base_url(gg().$giris->link) ?>";
                            }else if(response.error){
                                if(response.t==1){
                                    toastr.warning("<?= langS(59,2) ?>");
                                }else if(response.t==2){
                                    toastr.warning("<?= langS(171,2) ?>");
                                }
                            }
                        }else{
                            toastr.success("<?= langS(396,2) ?>");
                            setTimeout(function (){
                                window.location.reload();
                            },1200)
                        }

                    }
                });
            }else{
                toastr.warning("<?= langS(171,2) ?>");
            }
        });

        $("#paytrKredi").change(function (){
            $(".bottom-box2").removeClass("active");
            $(".bankaselect").prop("checked",false);
            $(".bottom-box3").fadeOut(200);
            $(".bottom-box2").fadeOut(200);
            $(".bottom-box").fadeIn(600);
            $("#amount").val("");
            $("#komHesap").fadeOut(300);
            $("#komHesap").html();
            $("#bas").html("");
        });

        $(".bankaselect").change(function (e){
            e.preventDefault();
            $(".bottom-box3").fadeIn(400);

        });

        $('.floats').keypress(function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });

        //category select
        $('.float-number').keypress(function (event) {
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        });
    });

</script>

<?php
if($this->uri->segment(3)=="vallet-havale"){
    $this->load->view("user/profile/bakiye/script/vallet_havale_script");
}
else if($this->uri->segment(3)=="paytr-kredi"){
    $this->load->view("user/profile/bakiye/script/paytr_kredi_script");
}
else if($this->uri->segment(3)=="paytr-havale"){
    $this->load->view("user/profile/bakiye/script/paytr_havale_script");
}
else if($this->uri->segment(3)=="papara"){
    $this->load->view("user/profile/bakiye/script/papara_kredi_script");
}
else if($this->uri->segment(3)=="shopier"){
    $this->load->view("user/profile/bakiye/script/shopier_kredi_script");
}
else if($this->uri->segment(3)=="gpay"){
    $this->load->view("user/profile/bakiye/script/gpay_kredi_script");
}
else if($this->uri->segment(3)=="gpay-havale"){
    $this->load->view("user/profile/bakiye/script/gpay_havale_script");
}
else if($this->uri->segment(2)=="manuel"){
    $this->load->view("user/profile/bakiye/script/manuel_script");
}
else if($this->uri->segment(2)=="epinkopin"){
    $this->load->view("user/profile/bakiye/script/epinkopin_script");
}
else if($this->uri->segment(3)=="vallet"){
    $this->load->view("user/profile/bakiye/script/vallet_kredi_script");
}
else if($this->uri->segment(3)=="payguru"){
    $this->load->view("user/profile/bakiye/script/payguru_kredi_script");
}

?>
