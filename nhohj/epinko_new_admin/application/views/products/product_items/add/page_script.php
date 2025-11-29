<script>
    $("[tags-input]").select2({
        tags: true,
        tokenSeparators: [','],
        maximumSelectionLength: 20,
        maximumInputLength: 20
    });

    let dataBefore = [];

    $("[tags-input]").on('select2:open', function () {
        dataBefore = $("[tags-input]").select2('data').map(item => item.id);
    });

    $("[tags-input]").on('select2:select', function (e) {
        const selectedItems = $("[tags-input]").select2('data').length;
        if (selectedItems > 20) {
            $("[tags-input]").val(dataBefore).trigger('change');
            alert('En fazla 20 seçim yapabilirsiniz!');
        }
    });

    $("[tags-input]").on('select2:unselect', function () {
        dataBefore = $("[tags-input]").select2('data').map(item => item.id);
    });
</script>
<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    //ckeditor verileri
    <?php
    if($this->settings->lang==1){
        $getLang=getTable("table_langs",array("status" => 1));
        if($getLang){
            foreach ($getLang as $item) {
                ?>
                CKEDITOR.replace( 'icerik_<?= $item->id ?>', {
                    filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
                } );
                CKEDITOR.replace( 'icerik2_<?= $item->id ?>', {
                    filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
                } );
                <?php
            }
        }
    }
    ?>
function gelisTextUpdate(deger) {
        if (deger == "a") {
            $("#price_gelis").val("");
        } else {
            $("#price_gelis").val(deger.toFixed(2));
        }
    }

    function satisTextUpdate(deger){
        if(deger=="a"){
            $("#satisText").removeClass("text-success");
            $("#satisText").addClass("text-danger");
            $("#satisText").html("Fiyat Giriniz");
        }else{
            $("#satisText").removeClass("text-danger");
            $("#satisText").addClass("text-success");
            $("#satisText").html(deger.toFixed(2).toString() + " <?= getcur(); ?>");
            $("#price_sell").val(deger.toFixed(2));
        }

    }
    function karTextUpdate(deger){
        $("#karText").removeClass("text-danger");
        $("#karText").addClass("text-success");
        $("#karText").html(deger.toFixed(2).toString() + " <?= getcur(); ?>");
    }
    function indTextUpdate(deger,deger2){
        $("#indirimText").removeClass("text-danger");
        $("#indirimText").addClass("text-success");
        $("#indirimText").html(deger.toFixed(2).toString() + " <?= getcur(); ?>");
        $("#indText").removeClass("text-danger");
        $("#indText").addClass("text-success");
        $("#indText").html(deger2.toFixed(2).toString() + " <?= getcur(); ?>");
    }

    $(document).ready(function() {
        $("#categories").select2();
        //satis fiyat
        $("#price_sell").bind('keyup mouseup', function () {
            var fiyat = $("#price_sell").val().replace(",", ".");
            var marj = $("#kar_marj").val().replace(",", ".");
            fiyat = parseFloat(fiyat);
            if ($(this).val() == "") {
                $("#karp").fadeOut(200);
                $("#kar_marj").val("");
                $("#discount_oran").val("");
                $("#price_gelis").val("");
                $("#indirim_oran").fadeOut(200);
                $("#indirimli_fiyat").fadeOut(200);
                gelisTextUpdate("a");
                satisTextUpdate("a");
            } else {
                if ($("#kar_marj").val() != "") {
                    if ($("#discount_oran").val() != "") {
                        var indirim = $("#discount_oran").val().replace(",", ".");
                        var islemkar = parseFloat(fiyat) / (100 + parseFloat(marj)) * parseFloat(marj); // 5
                        var islem = fiyat; // 55
                        var indirimli = parseFloat(islem * (100 - parseFloat(indirim)) / 100); // 49.5
                        var indirimTutar = parseFloat(islem * parseFloat(indirim) / 100); // 5.5
                        satisTextUpdate(islem);
                        gelisTextUpdate(islem - islemkar);
                        karTextUpdate(islemkar);
                        $("#indirim_oran").fadeIn(200);
                        $("#karp").fadeIn(200);
                        $("#indirimli_fiyat").fadeIn(200);
                        indTextUpdate(indirimTutar, indirimli);
                    } else {
                        var islemkar = (parseFloat(fiyat) / (100+parseFloat(marj))) * parseFloat(marj);
                        var islem = fiyat;
                        var gelisFiyat = fiyat - islemkar;
                        gelisTextUpdate(gelisFiyat);
                        satisTextUpdate(islem);
                        $("#karp").fadeIn(200);
                        karTextUpdate(islemkar);
                    }
                } else {
                    if ($("#discount_oran").val() == "") {
                        $("#karp").fadeOut(200);
                        satisTextUpdate(fiyat);
                        gelisTextUpdate(fiyat);
                    } else {
                        $("#karp").fadeOut(200);
                        var indirim = $("#discount_oran").val().replace(",", ".");
                        var indirimTutar = parseFloat(fiyat * parseFloat(indirim) / 100);
                        var indirimli = parseFloat(fiyat * (100 - parseFloat(indirim)) / 100);
                        $("#indirim_oran").fadeIn(200);
                        $("#indirimli_fiyat").fadeIn(200);
                        indTextUpdate(indirimTutar, indirimli);
                        satisTextUpdate(fiyat);
                        gelisTextUpdate(fiyat);
                    }
                }
            }
        });
        //fiyat
        $("#price_gelis").bind('keyup mouseup', function () {
            var fiyat= $("#price_gelis").val().replace(",",".");
            var marj= $("#kar_marj").val().replace(",",".");
            fiyat=parseFloat(fiyat);
            if($(this).val()==""){
                $("#karp").fadeOut(200);
                $("#kar_marj").val("");
                $("#discount_oran").val("");
                $("#indirim_oran").fadeOut(200);
                $("#indirimli_fiyat").fadeOut(200);
                satisTextUpdate("a");
            }else{
                if($("#kar_marj").val()!=""){
                    if($("#discount_oran").val()!=""){
                        var indirim= $("#discount_oran").val().replace(",",".");
                        var islemkar=parseFloat(((fiyat / 100) * marj));
                        var islem= parseFloat(((fiyat / 100) * marj))+parseFloat(fiyat);
                        var indirimli=  parseFloat(islem * (100-parseFloat(indirim)) / 100);
                        var indirimTutar=  parseFloat(islem * parseFloat(indirim) / 100);
                        satisTextUpdate(islem);
                        karTextUpdate(islemkar);
                        $("#indirim_oran").fadeIn(200);
                        $("#karp").fadeIn(200);
                        $("#indirimli_fiyat").fadeIn(200);
                        indTextUpdate(indirimTutar,indirimli);
                    }else{
                        var islemkar=parseFloat(((fiyat / 100) * marj));
                        var islem= parseFloat(((fiyat / 100) * marj))+parseFloat(fiyat);
                        satisTextUpdate(islem);
                        $("#karp").fadeIn(200);
                        karTextUpdate(islemkar);
                    }
                }else{
                    if($("#discount_oran").val()==""){
                        $("#karp").fadeOut(200);
                        satisTextUpdate(fiyat);
                    }else{
                        $("#karp").fadeOut(200);
                        var indirim= $("#discount_oran").val().replace(",",".");
                        var indirimTutar=  parseFloat(fiyat * parseFloat(indirim) / 100);
                        var indirimli=  parseFloat(fiyat * (100-parseFloat(indirim)) / 100);
                        $("#indirim_oran").fadeIn(200);
                        $("#indirimli_fiyat").fadeIn(200);
                        indTextUpdate(indirimTutar,indirimli);
                        satisTextUpdate(fiyat);
                    }
                }
            }
        });

        //marj
        $("#kar_marj").bind('keyup mouseup', function () {
            var fiyat= $("#price_gelis").val().replace(",",".");
            fiyat=parseFloat(fiyat);
            if($(this).val()==""){
                if($("#price_gelis").val()==""){
                    $("#karp").fadeOut(200);
                    satisTextUpdate("a");
                }else{
                    if($("#discount_oran").val()==""){
                        $("#karp").fadeOut(200);
                        satisTextUpdate(fiyat);
                    }else{
                        $("#karp").fadeOut(200);
                        var indirim= $("#discount_oran").val().replace(",",".");
                        var indirimTutar=  parseFloat(fiyat * parseFloat(indirim) / 100);
                        var indirimli=  parseFloat(fiyat * (100-parseFloat(indirim)) / 100);
                        $("#indirim_oran").fadeIn(200);
                        $("#indirimli_fiyat").fadeIn(200);
                        indTextUpdate(indirimTutar,indirimli);
                        satisTextUpdate(fiyat);
                    }
                }
            }else{
                if($(this).val()>100){
                    $(this).val(100);
                }else if( $(this).val()<0){
                    $(this).val(0);
                }else{
                    if($("#price_gelis").val()==""){
                        alertToggle(2,"Önce Fiyat Giriniz.","Uyarı");
                        $(this).val("");
                    }else{
                        if($("#kar_marj").val()!=""){
                            if($("#discount_oran").val()!=""){
                                var marj= $("#kar_marj").val().replace(",",".");
                                var indirim= $("#discount_oran").val().replace(",",".");
                                var islemkar=parseFloat(((fiyat / 100) * marj));
                                var islem= parseFloat(((fiyat / 100) * marj))+parseFloat(fiyat);
                                var indirimli=  parseFloat(islem * (100-parseFloat(indirim)) / 100);
                                var indirimTutar=  parseFloat(islem * parseFloat(indirim) / 100);
                                satisTextUpdate(islem);
                                $("#karText").removeClass("text-danger");
                                $("#karText").addClass("text-success");
                                $("#karText").html(islemkar.toFixed(2).toString() + " <?= getcur(); ?>");
                                $("#indirim_oran").fadeIn(200);
                                $("#karp").fadeIn(200);
                                $("#indirimli_fiyat").fadeIn(200);
                                $("#indirimText").removeClass("text-danger");
                                $("#indirimText").addClass("text-success");
                                $("#indirimText").html(indirimTutar.toFixed(2).toString() + " <?= getcur(); ?>");
                                $("#indText").removeClass("text-danger");
                                $("#indText").addClass("text-success");
                                $("#indText").html(indirimli.toFixed(2).toString() + " <?= getcur(); ?>");
                            }else{
                                $("#karp").fadeIn(200);
                                var marj= $("#kar_marj").val().replace(",",".");
                                var islemkar=parseFloat(((fiyat / 100) * marj));
                                var islem= parseFloat(((fiyat / 100) * marj))+parseFloat(fiyat);
                                satisTextUpdate(islem);
                                $("#karText").removeClass("text-danger");
                                $("#karText").addClass("text-success");
                                $("#karText").html(islemkar.toFixed(2).toString() + " <?= getcur(); ?>");
                            }
                        }else{
                            if($("#discount_oran").val()==""){
                                $("#karp").fadeOut(200);
                                satisTextUpdate(fiyat);
                            }else{
                                $("#karp").fadeOut(200);
                                var indirim= $("#discount_oran").val().replace(",",".");
                                var indirimTutar=  parseFloat(fiyat * parseFloat(indirim) / 100);
                                var indirimli=  parseFloat(fiyat * (100-parseFloat(indirim)) / 100);
                                $("#indirim_oran").fadeIn(200);
                                $("#indirimli_fiyat").fadeIn(200);
                                indTextUpdate(indirimTutar,indirimli);
                                satisTextUpdate(fiyat);
                            }

                        }
                    }
                }


            }
        });

        //indirim
        $("#discount_oran").bind('keyup mouseup', function () {
            var fiyat= $("#price_gelis").val().replace(",",".");
            fiyat=parseFloat(fiyat);
            if($(this).val()==""){
                $("#indirim_oran").fadeOut(200);
                $("#indirimli_fiyat").fadeOut(200);
                if($("#kar_marj").val()!=""){
                    var marj= $("#kar_marj").val().replace(",",".");
                    var islemkar=parseFloat(((fiyat / 100) * marj));
                    var islem= parseFloat(((fiyat / 100) * marj))+parseFloat(fiyat);
                    satisTextUpdate(islem)
                    $("#karp").fadeIn(200);
                    karTextUpdate(islemkar);
                }else{
                    $("#karp").fadeOut(200);
                    satisTextUpdate(fiyat);
                }
            }else{
                if($(this).val()>100){
                    $(this).val(100);
                }else if( $(this).val()<0){
                    $(this).val(0);
                }else{
                    if($("#price_gelis").val()==""){
                        $("#discount_oran").val("");
                        alertToggle(2,"Önce Fiyat Giriniz.","Uyarı");
                    }else{
                        if($("#kar_marj").val()!=""){
                            var marj= $("#kar_marj").val().replace(",",".");
                            var indirim= $("#discount_oran").val().replace(",",".");
                            var islemkar=parseFloat(((fiyat / 100) * marj));
                            var islem= parseFloat(((fiyat / 100) * marj))+parseFloat(fiyat);
                            var indirimli=  parseFloat(islem * (100-parseFloat(indirim)) / 100);
                            var indirimTutar=  parseFloat(islem * parseFloat(indirim) / 100);
                            satisTextUpdate(islem);
                            karTextUpdate(islemkar);
                            $("#indirim_oran").fadeIn(200);
                            $("#indirimli_fiyat").fadeIn(200);
                            indTextUpdate(indirimTutar,indirimli);
                        }else{
                            var indirim= $("#discount_oran").val().replace(",",".");
                            var indirimTutar=  parseFloat(fiyat * parseFloat(indirim) / 100);
                            var indirimli=  parseFloat(fiyat * (100-parseFloat(indirim)) / 100);
                            $("#karp").fadeOut(200);
                            $("#indirim_oran").fadeIn(200);
                            $("#indirimli_fiyat").fadeIn(200);
                            indTextUpdate(indirimTutar,indirimli);
                        }
                    }
                }
            }

        });

        //turkpin selectbox ajax
        $("body").on("change",".turkpinkategori ",function(){
            var id =$(this).val();
            if(id==0){
                $("#turkpinUrunCont").html('<label><b>Türkpin </b>Ürün</label><select name="turkpin_urun_id" class="form-control turkpinoyun"><option value="0">Önce Türkpin Kategori Seçiniz</option></select>');
            }else{
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url() ?>turkpin-get-product",
                    data:{data:id},
                    success: function(sonuc){
                        $("#turkpinUrunCont").html(sonuc);
                    }
                });
            }

        });
        $("body").on("change",".turkpinoyun",function(){
            var cat =$(".turkpinkategori").val();
            var id =$(this).val();
            if(cat==0 || id==0){
                $(".otomatikTurk").hide();
            }else{
                $(".otomatikTurk").show();

                $.ajax({
                    type: 'POST',
                    url: "<?= base_url() ?>turkpin-get-price",
                    data:{cat:cat,id:id},
                    success: function(sonuc){
                        var fiyat=parseFloat(sonuc);
                        $("#price_gelis").val(fiyat);
                        $("#price_gelis").trigger("keyup");
                        $("#price_gelis").trigger("mouseup");
                    }
                });
            }



        });

        $("#is_discount").change(function() {
            if(this.checked) {
                if($("#price_gelis").val()==""){
                    alertToggle(2,"Önce Fiyat Giriniz.","Uyarı");
                    $(this).prop('checked',false);
                }else{
                    $("#discountCont").fadeIn();
                }
            }else{
                var fiyat= $("#price_gelis").val().replace(",",".");
                fiyat=parseFloat(fiyat);
                if($("#kar_marj").val()!=""){
                    var marj= $("#kar_marj").val().replace(",",".");
                    var islemkar=parseFloat(((fiyat / 100) * marj));
                    var islem= parseFloat(((fiyat / 100) * marj))+parseFloat(fiyat);
                    satisTextUpdate(islem);
                    karTextUpdate(islemkar);
                    $("#karp").fadeIn(200);
                    $("#indirim_oran").fadeOut(200);
                    $("#indirimli_fiyat").fadeOut(200);
                }else{
                    $("#karp").fadeOut(200);
                    satisTextUpdate(fiyat);
                    $("#indirim_oran").fadeOut(200);
                    $("#indirimli_fiyat").fadeOut(200);
                }
                $("#discount_oran").val("");
                $("#discountCont").fadeOut();
            }
        });
        //selectboxlar değiştiğinde olacaklar

    });
</script>

