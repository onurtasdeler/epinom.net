<script src="<?= base_url("assets/js/") ?>select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/tinymce/tinymce.bundle.js"></script>
<script src="<?= base_url() ?>assets/tinymce/tinymce.js"></script>

<?php
if($uniq->type==1){
    //stoklu
    ?>
    <script>
        var themes="";
        var skin="";
        if($("body").hasClass("active-light-mode")){
            themes="";
            skin="oxide-dark";
        }else{
            themes="dark";
            skin="oxide-dark";
        }
        var catSelect="1";
        tinymce.init({
            selector: 'textarea#icerik_en',
            language: 'en',
            height : "400",
            cleanup : false,
            statusbar : false,
            menubar: false,
            toolbar: ['  ',
                ' bold italic | alignleft aligncenter  | forecolor backcolor',
                'bullist numlist |  indent |      '],
            plugins : 'advlist  lists textcolor ',
            skin: skin ,
            content_css: themes

        });
        tinymce.init({
            selector: 'textarea#icerik_tr',
            language_url: '<?= base_url("assets/tinymce/") ?>tr.js',
            language: 'tr',
            height : "400",
            cleanup : false,
            statusbar : false,
            menubar: false,
            toolbar: ['  ',
                ' bold italic | alignleft aligncenter  | forecolor backcolor',
                'bullist numlist |  indent |      '],
            plugins : 'advlist  lists textcolor ',
            skin: skin,
            content_css: themes
        });
        $(function() {

            $(".selects#mainCategory").select2({});
            $(".selectss").select2({});
            $(".selects#topCategory").select2({});
            $(".selects#subCategory").select2({});
            $('.selects#mainCategory').on('select2:select', function (e) {
                var data = e.params.data;
                if(data.id){
                    $.ajax({
                        url: "<?= base_url("get-category-top-list") ?>",
                        type: 'POST',
                        data: {veri:data.id,lang:"<?= $_SESSION["lang"] ?>",t:2},
                        success: function (response) {
                            if(response.veri=="yok"){
                                $(".selects#topCategory").html("").hide("");
                                $('.selects#topCategory').trigger('change.select2'); // Notify only Select2 of changes
                                $('.selects#topCategory').prop('required',true); // Notify only Select2 of changes
                                $('.selects#subCategory').prop('required',true); // Notify only Select2 of changes
                                $("#topCategoryCont").fadeOut(300);
                                $(".selects#subCategory").html("").hide("");
                                $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes
                                $("#subCategoryCont").fadeOut(300);
                                $("#speTitle").hide();
                                $("#speCont").html("");
                                $("#speTitle").hide();
                                $("#price").prop("disabled",false);
                                catSelect="1";
                            }else{
                                $("#topCategoryCont").fadeIn(300);
                                $(".selects#topCategory").html (response.veri);
                                $('.selects#topCategory').prop('required',true); // Notify only Select2 of changes
                                $('.selects#topCategory').trigger('change.select2'); // Notify only Select2 of changes
                                catSelect="";
                                $("#price").prop("disabled",true);
                                $("#price").val("");
                            }
                        },
                    });
                }else{
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
            $('.selects#topCategory').on('select2:select', function (e) {
                var data = e.params.data;
                if(data.id){
                    $.ajax({
                        url: "<?= base_url("get-category-top-list?t=1") ?>",
                        type: 'POST',
                        data: {veri:data.id,lang:"<?= $_SESSION["lang"] ?>",t:2},
                        success: function (response) {
                            if(response.veri=="yok"){
                                $('.selects#subCategory').prop('required',false); // Notify only Select2 of changes
                                $(".selects#subCategory").html("").hide("");
                                $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes
                                $("#subCategoryCont").fadeOut(300);
                                $("#speTitle").hide();
                                $("#speCont").html("");
                                $("#speTitle").hide();
                                $("#price").prop("disabled",false);
                                catSelect="1";
                            }else{
                                if(response.spe){
                                    $("#speCont").html(response.spe).fadeIn(300);
                                    $("#speCont .selectss").select2({});
                                    $("#speTitle").fadeIn(200);
                                }else{
                                    $("#speTitle").hide();
                                    $("#speCont").html("");
                                    $("#speTitle").hide();
                                }
                                catSelect="";
                                $("#price").prop("disabled",true);
                                $("#price").val("");
                                $('.selects#subCategory').prop('required',true); // Notify only Select2 of changes
                                $("#subCategoryCont").fadeIn(300);
                                $(".selects#subCategory").html (response.veri);
                                $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes

                            }
                        },
                    });
                }else{
                    $("#price").prop("disabled",true);
                    catSelect="";
                    $('.selects#subCategory').prop('required',false); // Notify only Select2 of changes
                    $("#subCategoryCont").fadeOut(300);
                    $(".selects#subCategory").html ("");
                    $('.selects#subCategory').trigger('change.select2'); // Notify only Select2 of changes
                    $("#price").val("");
                }

            })
            $('.selects#subCategory').on('select2:select', function (e) {
                var data = e.params.data;
                if(data.id){
                    $("#price").prop("disabled",false);
                    catSelect="1";
                }else{
                    $("#price").prop("disabled",true);
                    catSelect="";
                    $("#price").val("");
                }

            });

        });



        <?php $user = getActiveUsers(); ?>
        /*function escapeHtml(input) {
            return input.replace(/</g, "").replace(/>/g, "").replace(/&/g, "").replace(/%/g, "").replace(/"/g, "").replace(/'/g, "");
        }*/


        function escapeHtml(input) {
            return input.replace(/[&<>"']/g, function (match) {
                return {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#39;'
                }[match];
            });
        }
        function deleteStok(id){
            $("#add-" + id).remove();
        }
        var silinecek="";
        function modalActives(code,token){
            $("#descc12").html(code);
            silinecek=token;
        }

        $(document).ready(function () {

            $("#stokDelete").on("click",function (){
                $("#stokDelete").prop("disabled",true);
                if(silinecek){
                    $.ajax({
                        url: "<?= base_url("delete-stock") ?>",
                        type: 'POST',
                        data: {token:silinecek,uniq:"<?= $uniq->ilanNo ?>"},
                        success: function (response) {
                            if(response.hata=="var"){
                                toastr.warning(response.message);
                                $("#stokDelete").prop("disabled",false);
                            }else{
                                $("#stokDelete").remove();
                                toastr.success(response.message);
                                setTimeout(function (){
                                    window.location.reload();
                                },1500);
                            }
                        },
                    });
                }
            })

            var sayTable=1;




            $("#add_row").on("click",function (){
                if($("#codess").val() && $("#codess").val().length<200){
                    var str=$("#codess").val();


                    if(catSelect!=""){
                        if($("#price").val()){
                            if($("#price").val()>0){
                                $("#add_row").prop("disabled",true);
                                $.ajax({
                                    url: "<?= base_url("add-stock-product") ?>",
                                    type: 'POST',
                                    data: {codes:str,uniq:"<?= $uniq->ilanNo ?>",t:2,},
                                    success: function (response) {
                                        if(response.hata=="var"){
                                            toastr.warning(response.message);
                                            $("#add_row").prop("disabled",false);
                                        }else{
                                            toastr.success(response.message);
                                            $("#stockadd").html(response.adet + "<?= ($_SESSION["lang"]==1)?" Adet":" Piece" ?>");
                                            //$("#sttt").html(response.str);
                                            $("#unitprice").html(response.unit);
                                            $("#codess").val("");
                                            $("#add_row").prop("disabled",false);
                                            setTimeout(function (){
                                                window.location.reload();
                                            },1400);
                                            if(response.komisyon_oran){
                                                $("#komOran").html(response.komisyon_oran);
                                                $("#stockadd").html(response.stok);
                                                $("#komamount").html(response.komisyon);
                                                $("#cash").html(response.cash);
                                                $("#unitcash").html(response.unit_cash);
                                            }else{
                                                $("#stockadd").html(response.stok);
                                                $("#komamount").html(response.komisyon);
                                                $("#cash").html(response.cash);
                                            }

                                        }
                                    },
                                });
                            }
                        }
                    }

                }else{
                    if($("#codess").val().length>200){
                        toastr.warning("<?= ($_SESSION["lang"] == 1)?"Stok Kodu Alanı Çok Uzun.":"Stock Code Field Too Long." ?>");
                    }else{
                        toastr.warning("<?= ($_SESSION["lang"] == 1)?"Lütfen Stok Kodu Giriniz":"Please enter stock code." ?>");
                    }
                }





            });

            $("#price").on("change keyup click",function (){
                if(catSelect!=""){
                    if($("#price").val()){
                        if($("#price").val()>0){

                                $.ajax({
                                    url: "<?= base_url("get-price-no-stock-com") ?>",
                                    type: 'POST',
                                    data: {price:$("#price").val(),main:$("#mainCategory").val(),top:$("#topCategory").val(),sub:$("#subCategory").val(),lang:"<?= $_SESSION["lang"] ?>",t:2,},
                                    success: function (response) {
                                        if(response.hata){

                                        }else{
                                            $("#unitprice").html(response.unit);
                                            if(response.komisyon_oran){
                                                $("#komOran").html(response.komisyon_oran);
                                                $("#komamount").html(response.komisyon);
                                                $("#cash").html(response.unit_cash);
                                                $("#unitcash").html(response.unit_cash);
                                            }else{
                                                $("#komamount").html(response.komisyon);
                                                $("#cash").html(response.unit_cash);

                                            }
                                        }
                                    },
                                });


                        }else{
                            $("#price").val("");
                            $("#komamount").html("-");
                            $("#unitprice").html("-");
                            $("#cash").html("-");
                            $("#komOran").html("<?= ($user->magaza_ozel_komisyon!=0)?"%".$user->magaza_ozel_komisyon." <small class='text-warning'>(".langS(91,2).")</small>":"-" ?>");
                            $("#cash").html("-");
                        }
                    }else{
                        $("#komamount").html("-");
                        $("#unitprice").html("-");
                        $("#cash").html("-");
                        $("#komOran").html("<?= ($user->magaza_ozel_komisyon!=0)?"%".$user->magaza_ozel_komisyon." <small class='text-warning'>(".langS(91,2).")</small>":"-" ?>");
                        $("#cash").html("-");
                    }
                }else{
                    $("#price").val("");
                    $("#price").prop("disabled",true);
                }
            });
            $("#fatima").change(function () {
                var ext = $(this).val().split('.').pop();
                if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {
                    if (this.files[0].size > 2000000) {
                        toastr.warning("<?= langS(58, 2) ?>")
                        $("#rbtinput1").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                    } else {
                        $("#profileImageLabel").html();
                    }
                } else {
                    toastr.warning("<?= langS(75, 2) ?>");
                    $("#rbtinput1").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                }
            });

            $("#nipa").change(function () {
                var ext = $(this).val().split('.').pop();
                if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {
                    if (this.files[0].size > 2000000) {
                        toastr.warning("<?= langS(58, 2) ?>")
                        $("#rbtinput2").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                    } else {
                        $("#profileImageLabel").html();
                    }
                } else {
                    toastr.warning("<?= langS(75, 2) ?>");
                    $("#rbtinput2").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                }
            });

            $("#nipa2").change(function () {
                var ext = $(this).val().split('.').pop();
                if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {
                    if (this.files[0].size > 2000000) {
                        toastr.warning("<?= langS(58, 2) ?>")
                        $("#rbtinput3").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                    } else {
                        $("#profileImageLabel").html();
                    }
                } else {
                    toastr.warning("<?= langS(75, 2) ?>");
                    $("#rbtinput3").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                }
            });

            var s="";
            $(".imgDelete").on("click",function (){
                s=$(this).data("val");
                if(s){
                    $("#placebidModal3").modal("show");
                }
            })



            $("#img_delete_button").on("click",function (){
                if(s!=""){
                    $("#img_delete_button").prop("disabled",true);
                    $.ajax({
                        url: "<?= base_url("img-delete-pro/".$uniq->ilanNo) ?>",
                        type: 'POST',
                        data: {data:s},
                        success: function (response) {
                            if (response) {
                                if (response.hata == "var") {
                                    $("#uyCont4 .alert").html(response.message);
                                    $("#uyCont4").fadeIn(500);
                                    $("#img_delete_button").prop("disabled", false);
                                } else {
                                    $("#uyCont4 .alert").removeClass("alert-warning").addClass("alert-success");
                                    $("#uyCont4 .alert").html(response.message);
                                    $("#uyCont4").fadeIn(500);
                                    $("#img_delete_button").remove();
                                    toastr.success(response.message);
                                    setTimeout(function () {
                                        window.location.reload();
                                    }, 2000);
                                }
                            } else {
                                window.location.reload();
                            }
                        },
                        cache: false,

                    });
                }
            });


            $("#ilanCreateForm").validate({
                rules: {

                },
                messages: {

                },
                submitHandler: function (form) {
                    var formData = new FormData(document.getElementById("ilanCreateForm"));
                    $("#submitButton").prop("disabled", true);
                    $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");
                    $.ajax({
                        url: "<?= base_url("get-price-stock-update/".$uniq->ilanNo) ?>",
                        type: 'POST',
                        data: formData,
                        success: function (response) {
                            if (response) {
                                if (response.hata == "var") {
                                    if (response.type == "valid") {
                                        $("#uyCont .alert").html(response.message);
                                        $("#uyCont").fadeIn(500);
                                        $("#submitButton").prop("disabled", false);
                                        $("#submitButton").html("<i class='fa fa-check'></i> <?= ($_SESSION["lang"]==1)?"İlanı Güncelle":"Update Product" ?>");
                                    }else if(response.type="oturum"){
                                        window.location.reload();
                                    } else {
                                        toastr.warning(response.message);
                                        $("#submitButton").prop("disabled", false);
                                        $("#submitButton").html("<i class='fa fa-check'></i> <?= ($_SESSION["lang"]==1)?"İlanı Güncelle":"Update Product" ?>");
                                    }
                                } else {
                                    $(".deleted").remove();
                                    $("#uyCont .alert").removeClass("alert-danger").addClass("alert-success");
                                    $("#uyCont .alert").html(response.message);
                                    $("#uyCont").fadeIn(500);
                                    $("#submitButton").remove();
                                    toastr.success(response.message);
                                    setTimeout(function () {
                                        window.location.reload();
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

            var table = $('#kt_datatable');
            table.DataTable({
                responsive: true,
                orderable:false,
                searchDelay: 500,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Turkish.json"
                },
                dom: 'rtip',

            });

        });
    </script>
    <?php
}
else{
    //stoksuz
    ?>
    <script>
        var themes="";
        var skin="";
        if($("body").hasClass("active-light-mode")){
            themes="";
            skin="oxide-dark";
        }else{
            themes="dark";
            skin="oxide-dark";
        }
        var catSelect="1";
        tinymce.init({
            selector: 'textarea#icerik_en',
            language: 'en',
            height : "400",
            cleanup : false,
            statusbar : false,
            menubar: false,
            toolbar: ['  ',
                ' bold italic | alignleft aligncenter  | forecolor backcolor',
                'bullist numlist |  indent |      '],
            plugins : 'advlist  lists textcolor ',
            skin: skin ,
            content_css: themes

        });
        tinymce.init({
            selector: 'textarea#icerik_tr',
            language_url: '<?= base_url("assets/tinymce/") ?>tr.js',
            language: 'tr',
            height : "400",
            cleanup : false,
            statusbar : false,
            menubar: false,
            toolbar: ['  ',
                ' bold italic | alignleft aligncenter  | forecolor backcolor',
                'bullist numlist |  indent |      '],
            plugins : 'advlist  lists textcolor ',
            skin: skin,
            content_css: themes
        });
        $(function() {
            $(".selects#mainCategory").select2({});
            $(".selectss").select2({});
            $(".selects#topCategory").select2({});
            $(".selects#subCategory").select2({});
        });
        <?php $user = getActiveUsers(); ?>

        $(document).ready(function () {
            var degisen=0;


            <?php
            if($uniq->status == 4 && $uniq->type==0){

            }else{
                ?>
                $("#price").on("change keyup click",function (){
                    if(catSelect!=""){
                        if($("#price").val()){
                            if($("#price").val()>0 && $("#price").val()<1000000){

                                $.ajax({
                                    url: "<?= base_url("get-price-no-stock-com") ?>",
                                    type: 'POST',
                                    data: {price:$("#price").val(),main:$("#mainCategory").val(),top:$("#topCategory").val(),sub:$("#subCategory").val(),lang:"<?= $_SESSION["lang"] ?>",t:1,},
                                    success: function (response) {
                                        if(response.hata){

                                        }else{
                                            $("#unitprice").html(response.unit);
                                            if(response.komisyon_oran){
                                                $("#komOran").html(response.komisyon_oran);
                                                $("#komamount").html(response.komisyon);
                                                $("#cash").html(response.cash);
                                            }else{
                                                $("#komamount").html(response.komisyon);
                                                $("#cash").html(response.cash);
                                            }
                                        }
                                    },
                                });


                            }else{
                                $("#price").val("");
                                $("#komamount").html("-");
                                $("#unitprice").html("-");
                                $("#cash").html("-");
                                $("#komOran").html("<?= ($user->magaza_ozel_komisyon!=0)?"%".$user->magaza_ozel_komisyon." <small class='text-warning'>(".langS(91,2).")</small>":"-" ?>");
                                ("#cash").html("-");
                            }
                        }else{
                            $("#komamount").html("-");
                            $("#unitprice").html("-");
                            $("#cash").html("-");
                            $("#komOran").html("<?= ($user->magaza_ozel_komisyon!=0)?"%".$user->magaza_ozel_komisyon." <small class='text-warning'>(".langS(91,2).")</small>":"-" ?>");
                            ("#cash").html("-");
                        }
                    }else{
                        $("#price").val("");
                        $("#price").prop("disabled",true);
                    }
                });

                $("#fatima").change(function () {
                    var ext = $(this).val().split('.').pop();
                    if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {
                        if (this.files[0].size > 2000000) {
                            toastr.warning("<?= langS(58, 2) ?>")
                            $("#rbtinput1").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                        } else {
                            $("#profileImageLabel").html();
                        }
                    } else {
                        toastr.warning("<?= langS(75, 2) ?>");
                        $("#rbtinput1").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                    }
                });

                $("#nipa").change(function () {
                    var ext = $(this).val().split('.').pop();
                    if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {
                        if (this.files[0].size > 2000000) {
                            toastr.warning("<?= langS(58, 2) ?>")
                            $("#rbtinput2").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                        } else {
                            $("#profileImageLabel").html();
                        }
                    } else {
                        toastr.warning("<?= langS(75, 2) ?>");
                        $("#rbtinput2").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                    }
                });

                $("#nipa2").change(function () {
                    var ext = $(this).val().split('.').pop();
                    if (ext == "jpg" || ext == "png" || ext == "jpeg" || ext == "JPG" || ext == "PNG" || ext == "JPEG") {
                        if (this.files[0].size > 2000000) {
                            toastr.warning("<?= langS(58, 2) ?>")
                            $("#rbtinput3").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                        } else {
                            $("#profileImageLabel").html();
                        }
                    } else {
                        toastr.warning("<?= langS(75, 2) ?>");
                        $("#rbtinput3").attr("src","<?= base_url() ?>assets/images/portfolio/portfolio-10.jpg");
                    }
                });

                var s="";
                $(".imgDelete").on("click",function (){
                    s=$(this).data("val");
                    if(s){
                        $("#placebidModal2").modal("show");
                    }
                })

                $("#img_delete_button").on("click",function (){
                    if(s!=""){
                        $("#img_delete_button").prop("disabled",true);
                        $.ajax({
                            url: "<?= base_url("img-delete-pro/".$uniq->ilanNo) ?>",
                            type: 'POST',
                            data: {data:s},
                            success: function (response) {
                                if (response) {
                                    if (response.hata == "var") {
                                        $("#uyCont4 .alert").html(response.message);
                                        $("#uyCont4").fadeIn(500);
                                        $("#img_delete_button").prop("disabled", false);
                                    } else {
                                        $("#uyCont4 .alert").removeClass("alert-warning").addClass("alert-success");
                                        $("#uyCont4 .alert").html(response.message);
                                        $("#uyCont4").fadeIn(500);
                                        $("#img_delete_button").remove();
                                        toastr.success(response.message);
                                        setTimeout(function () {
                                            window.location.reload();
                                        }, 2000);
                                    }
                                } else {
                                    window.location.reload();
                                }
                            },
                            cache: false,

                        });
                    }
                });

                $("#ilanCreateForm").validate({
                    rules: {

                    },
                    messages: {

                    },
                    submitHandler: function (form) {
                        var formData = new FormData(document.getElementById("ilanCreateForm"));
                        $("#submitButton").prop("disabled", true);
                        $("#submitButton").html("<i class='fa fa-spinner fa-spin'></i> <?= langS(14, 2) ?>");
                        $.ajax({
                            url: "<?= base_url("get-price-no-stock-update/".$uniq->ilanNo) ?>",
                            type: 'POST',
                            data: formData,
                            success: function (response) {
                                if (response) {
                                    if (response.hata == "var") {
                                        if (response.type == "valid") {
                                            $("#uyCont .alert").html(response.message);
                                            $("#uyCont").fadeIn(500);
                                            $("#submitButton").prop("disabled", false);
                                            $("#submitButton").html("<i class='fa fa-check'></i> <?= ($_SESSION["lang"]==1)?"İlanı Güncelle":"Update Product" ?>");
                                        }else if(response.type="oturum"){
                                            window.location.reload();
                                        } else {
                                            toastr.warning(response.message);
                                            $("#submitButton").prop("disabled", false);
                                            $("#submitButton").html("<i class='fa fa-check'></i> <?= ($_SESSION["lang"]==1)?"İlanı Güncelle":"Update Product" ?>");
                                        }
                                    } else {
                                        $(".deleted").remove();
                                        $("#uyCont .alert").removeClass("alert-danger").addClass("alert-success");
                                        $("#uyCont .alert").html(response.message);
                                        $("#uyCont").fadeIn(500);
                                        $("#submitButton").remove();
                                        toastr.success(response.message);
                                        setTimeout(function () {
                                            window.location.reload();
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
            <?php
            }
            ?>



        });
    </script>
    <?php
}
?>





