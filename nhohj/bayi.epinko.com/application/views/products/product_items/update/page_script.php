<script src="<?= base_url() ?>assets/backend/ckeditor/ckeditor.js"></script>

<script src="<?= base_url() ?>assets/backend/js/pages/features/miscellaneous/toastr.js"></script>
<!--end::Page Vendors-->
<script>
    <?php
    $uye=getTableSingle("table_users",array("token" => $_SESSION["user_one"]["user"]));

    ?>
    var komisyonn=<?= $uye->bayi_komisyon ?>;
    $(function () {

        <?php
        if($this->settings->lang == 1){
        $getLang = getTable("table_langs", array("status" => 1));
        if($getLang){
        foreach ($getLang as $item) {
        ?>
        $ck<?= $item->id ?> = CKEDITOR.replace('icerik_<?= $item->id ?>', {
            filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
        });
        $ck<?= $item->id ?>.on('change', function () {
            $ck<?= $item->id ?>.updateElement();
        });
        $ck2<?= $item->id ?> = CKEDITOR.replace('icerik2_<?= $item->id ?>', {
            filebrowserImageUploadUrl: "<?=base_url();?>imageUploadCK?type=image&CKEditorFuncNum=1&namse=haber-yazi-icerik",
        });
        $ck2<?= $item->id ?>.on('change', function () {
            $ck2<?= $item->id ?>.updateElement();
        });
        <?php
        }
        }
        }
        ?>
    });

    function satisTextUpdate(deger) {
        if (deger == "a") {
            $("#satisText").removeClass("text-success");
            $("#satisText").addClass("text-danger");
            $("#satisText").html("Fiyat Giriniz");
        } else {
            $("#satisText").removeClass("text-danger");
            $("#satisText").addClass("text-success");
            $("#satisText").html(deger.toFixed(2).toString() + " ₺");
        }

    }

    function karTextUpdate(deger) {
        $("#karText").removeClass("text-danger");
        $("#karText").addClass("text-success");
        $("#karText").html(deger.toFixed(2).toString() + " ₺");
    }

    function indTextUpdate(deger, deger2) {

        $("#indirimText").html(deger.toFixed(2).toString() + " ₺");

        $("#indText").html(deger2.toFixed(2).toString() + " ₺");
    }

    function deleteModal(id, tur) {
        var a = "";
        $.post("<?= base_url('urun-cek') ?>", {data: id}, function (response) {
            if (response) {
                $("#makaleId").html('<strong style="color:green">' + response + "</strong>");
                $("#silinecek").val(id);
                $("#tur").val(tur);
            } else {
                alertToggle(2, "Bir hata meydana geldi.", "hata ");
            }
        });
    }

    function deleteModalSubmit() {
        var a = $("#silinecek").val();
        var tur = $("#tur").val();
        if (a != "") {
            $.post("<?= base_url('urun-img-sil') ?>", {data: a, tur: tur}, function (response) {
                if (response) {
                    alertToggle(1, "Resim Silindi.", "Başarılı");
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    alertToggle(2, "Hata", "Hata");
                }
            });
        }
    }

    $(document).ready(function () {
        var ilkval="";




        //fiyat
        $("#price_gelis").bind('keyup mouseup', function () {
            var fiyat = $("#price_gelis").val().replace(",", ".");
            var marj = $("#kar_marj").val().replace(",", ".");
            fiyat = parseFloat(fiyat);
            if ($(this).val() == "") {
                $("#karp").fadeOut(200);
                $("#discount_oran").val("");
                $("#indirim_oran").fadeOut(200);
                $("#indirimli_fiyat").fadeOut(200);
                satisTextUpdate("a");
            } else {
                if ($("#kar_marj").val() != "") {
                    if ($("#discount_oran").val() != "") {
                        var indirim = $("#discount_oran").val().replace(",", ".");
                        var islemkar = parseFloat(((fiyat / 100) * marj));
                        var islem = parseFloat(((fiyat / 100) * marj)) + parseFloat(fiyat);
                        var indirimli = parseFloat(islem * (100 - parseFloat(indirim)) / 100);
                        var indirimTutar = parseFloat(islem * parseFloat(indirim) / 100);
                        var komisyontutar= parseFloat(indirimli * parseFloat(komisyonn) / 100);
                        $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                        $("#netkazanc").html(indirimli - komisyontutar + " ₺");
                        satisTextUpdate(islem);
                        karTextUpdate(islemkar);
                        $("#indirim_oran").fadeIn(200);
                        $("#karp").fadeIn(200);
                        $("#indirimli_fiyat").fadeIn(200);
                        indTextUpdate(indirimTutar, indirimli);
                    } else {
                        var islemkar = parseFloat(((fiyat / 100) * marj));
                        var islem = parseFloat(((fiyat / 100) * marj)) + parseFloat(fiyat);
                        var komisyontutar= parseFloat(islem * parseFloat(komisyonn) / 100);
                        $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺" );
                        $("#netkazanc").html(islem - komisyontutar + " ₺");
                        satisTextUpdate(islem);
                        $("#karp").fadeIn(200);
                        karTextUpdate(islemkar);
                    }
                } else {
                    if ($("#discount_oran").val() == "") {
                        $("#karp").fadeOut(200);
                        satisTextUpdate(fiyat);
                    } else {
                        $("#karp").fadeOut(200);
                        var indirim = $("#discount_oran").val().replace(",", ".");
                        var indirimTutar = parseFloat(fiyat * parseFloat(indirim) / 100);
                        var indirimli = parseFloat(fiyat * (100 - parseFloat(indirim)) / 100);
                        var komisyontutar= parseFloat(indirimli * parseFloat(komisyonn) / 100);
                        $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                        $("#netkazanc").html(indirimli - komisyontutar + " ₺");
                        $("#indirim_oran").fadeIn(200);
                        $("#indirimli_fiyat").fadeIn(200);
                        indTextUpdate(indirimTutar, indirimli);
                        satisTextUpdate(fiyat);
                    }
                }
            }
        });

        //marj
        $("#kar_marj").bind('keyup mouseup', function () {
            var fiyat = $("#price_gelis").val().replace(",", ".");
            fiyat = parseFloat(fiyat);
            if ($(this).val() == "") {
                if ($("#price_gelis").val() == "") {
                    $("#karp").fadeOut(200);
                    satisTextUpdate("a");
                } else {
                    if ($("#discount_oran").val() == "") {
                        $("#karp").fadeOut(200);
                        satisTextUpdate(fiyat);
                    } else {
                        $("#karp").fadeOut(200);
                        var indirim = $("#discount_oran").val().replace(",", ".");
                        var indirimTutar = parseFloat(fiyat * parseFloat(indirim) / 100);
                        var indirimli = parseFloat(fiyat * (100 - parseFloat(indirim)) / 100);
                        var komisyontutar= parseFloat(indirimli * parseFloat(komisyonn) / 100);
                        $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                        $("#netkazanc").html(indirimli - komisyontutar + " ₺");
                        $("#indirim_oran").fadeIn(200);
                        $("#indirimli_fiyat").fadeIn(200);
                        indTextUpdate(indirimTutar, indirimli);
                        satisTextUpdate(fiyat);
                    }
                }
            } else {
                if ($(this).val() > 100) {
                    $(this).val(100);
                } else if ($(this).val() < 0) {
                    $(this).val(0);
                } else {
                    if ($("#price_gelis").val() == "") {
                        alertToggle(2, "Önce Fiyat Giriniz.", "Uyarı");
                        $(this).val("");
                    } else {
                        if ($("#kar_marj").val() != "") {
                            if ($("#discount_oran").val() != "") {
                                var marj = $("#kar_marj").val().replace(",", ".");
                                var indirim = $("#discount_oran").val().replace(",", ".");
                                var islemkar = parseFloat(((fiyat / 100) * marj));
                                var islem = parseFloat(((fiyat / 100) * marj)) + parseFloat(fiyat);
                                var indirimli = parseFloat(islem * (100 - parseFloat(indirim)) / 100);
                                var indirimTutar = parseFloat(islem * parseFloat(indirim) / 100);
                                var komisyontutar= parseFloat(indirimli * parseFloat(komisyonn) / 100);
                                $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                                $("#netkazanc").html(indirimli - komisyontutar + " ₺");
                                satisTextUpdate(islem);
                                karTextUpdate(islemkar);
                                $("#indirim_oran").fadeIn(200);
                                $("#karp").fadeIn(200);
                                $("#indirimli_fiyat").fadeIn(200);
                                indTextUpdate(indirimTutar, indirimli);
                            } else {
                                $("#karp").fadeIn(200);
                                var marj = $("#kar_marj").val().replace(",", ".");
                                var islemkar = parseFloat(((fiyat / 100) * marj));
                                var islem = parseFloat(((fiyat / 100) * marj)) + parseFloat(fiyat);
                                var komisyontutar= parseFloat(islem * parseFloat(komisyonn) / 100);
                                $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                                $("#netkazanc").html(islem - komisyontutar + " ₺");
                                $("#satisText").removeClass("text-danger");
                                $("#satisText").addClass("text-success");
                                $("#satisText").html(islem.toFixed(2).toString() + " ₺");
                                $("#karText").removeClass("text-danger");
                                $("#karText").addClass("text-success");
                                $("#karText").html(islemkar.toFixed(2).toString() + " ₺");
                            }
                        } else {
                            if ($("#discount_oran").val() == "") {
                                $("#karp").fadeOut(200);
                                $("#satisText").removeClass("text-danger");
                                $("#satisText").addClass("text-success");
                                $("#satisText").html(fiyat.toFixed(2).toString() + " ₺");
                            } else {
                                $("#karp").fadeOut(200);
                                var indirim = $("#discount_oran").val().replace(",", ".");
                                var indirimTutar = parseFloat(fiyat * parseFloat(indirim) / 100);
                                var indirimli = parseFloat(fiyat * (100 - parseFloat(indirim)) / 100);
                                var komisyontutar= parseFloat(indirimli * parseFloat(komisyonn) / 100);
                                $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                                $("#netkazanc").html(indirimli - komisyontutar + " ₺");
                                $("#indirim_oran").fadeIn(200);
                                $("#indirimli_fiyat").fadeIn(200);
                                indTextUpdate(indirimTutar, indirimli);
                                satisTextUpdate(fiyat);
                            }

                        }
                    }
                }


            }
        });

        //indirim
        $("#discount_oran").bind('keyup mouseup', function () {
            var fiyat = $("#price_gelis").val().replace(",", ".");
            fiyat = parseFloat(fiyat);
            if ($(this).val() == "") {
                $("#indirim_oran").fadeOut(200);
                $("#indirimli_fiyat").fadeOut(200);
                if ($("#kar_marj").val() != "") {
                    var marj = $("#kar_marj").val().replace(",", ".");
                    var islemkar = parseFloat(((fiyat / 100) * marj));
                    var islem = parseFloat(((fiyat / 100) * marj)) + parseFloat(fiyat);
                    var komisyontutar= parseFloat(islem * parseFloat(komisyonn) / 100);
                    $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                    $("#netkazanc").html(islem - komisyontutar + " ₺");
                    satisTextUpdate(islem)
                    $("#karp").fadeIn(200);
                    karTextUpdate(islemkar);
                } else {
                    $("#karp").fadeOut(200);
                    satisTextUpdate(fiyat);
                }
            } else {
                if ($(this).val() > 100) {
                    $(this).val(100);
                } else if ($(this).val() < 0) {
                    $(this).val(0);
                } else {
                    if ($("#price_gelis").val() == "") {
                        $("#discount_oran").val("");
                        alertToggle(2, "Önce Fiyat Giriniz.", "Uyarı");
                    } else {
                        if ($("#kar_marj").val() != "") {
                            var marj = $("#kar_marj").val().replace(",", ".");
                            var indirim = $("#discount_oran").val().replace(",", ".");
                            var islemkar = parseFloat(((fiyat / 100) * marj));
                            var islem = parseFloat(((fiyat / 100) * marj)) + parseFloat(fiyat);
                            var indirimli = parseFloat(islem * (100 - parseFloat(indirim)) / 100);
                            var indirimTutar = parseFloat(islem * parseFloat(indirim) / 100);
                            var komisyontutar= parseFloat(indirimli * parseFloat(komisyonn) / 100);
                            $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                            $("#netkazanc").html(indirimli - komisyontutar + " ₺");
                            satisTextUpdate(islem);
                            karTextUpdate(islemkar);
                            $("#indirim_oran").fadeIn(200);
                            $("#indirimli_fiyat").fadeIn(200);
                            indTextUpdate(indirimTutar, indirimli);
                        } else {
                            var indirim = $("#discount_oran").val().replace(",", ".");
                            var indirimTutar = parseFloat(fiyat * parseFloat(indirim) / 100);
                            var indirimli = parseFloat(fiyat * (100 - parseFloat(indirim)) / 100);
                            var komisyontutar= parseFloat(indirimli * parseFloat(komisyonn) / 100);
                            $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                            $("#netkazanc").html(indirimli - komisyontutar + " ₺");
                            $("#karp").fadeOut(200);
                            $("#indirim_oran").fadeIn(200);
                            $("#indirimli_fiyat").fadeIn(200);
                            indTextUpdate(indirimTutar, indirimli);
                        }
                    }
                }
            }

        });

        //turkpin selectbox ajax




        $("#is_discount").change(function () {
            if (this.checked) {
                if ($("#price_gelis").val() == "") {
                    alertToggle(2, "Önce Fiyat Giriniz.", "Uyarı");
                    $(this).prop('checked', false);
                } else {
                    $("#discountCont").fadeIn();
                }
            } else {
                var fiyat = $("#price_gelis").val().replace(",", ".");
                fiyat = parseFloat(fiyat);
                if ($("#kar_marj").val() != "") {
                    var marj = $("#kar_marj").val().replace(",", ".");
                    var islemkar = parseFloat(((fiyat / 100) * marj));
                    var islem = parseFloat(((fiyat / 100) * marj)) + parseFloat(fiyat);
                    var komisyontutar= parseFloat(islem * parseFloat(komisyonn) / 100);
                    $("#komisyontutar").html(komisyontutar.toFixed(2) + " ₺");
                    $("#netkazanc").html(islem - komisyontutar + " ₺");
                    satisTextUpdate(islem);
                    karTextUpdate(islemkar);
                    $("#karp").fadeIn(200);
                    $("#indirim_oran").fadeOut(200);
                    $("#indirimli_fiyat").fadeOut(200);
                } else {
                    $("#karp").fadeOut(200);
                    satisTextUpdate(fiyat);
                    $("#indirim_oran").fadeOut(200);
                    $("#indirimli_fiyat").fadeOut(200);
                }
                $("#discount_oran").val("");
                $("#discountCont").fadeOut();
            }
        });
        $("#guncelleForm").on("submit", function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            $.ajax({
                url: "<?= base_url("urun-guncelle/" . $data["veri"]->id) ?>",
                type: 'POST',
                data: formData,
                success: function (response) {
                    if (response) {
                        if (response.err) {
                            alertS(response.message, "error");
                        } else {
                            alertS(response.message, "success");

                        }
                    } else {
                        alertToggle(2, "Bir hata meydana geldi.", "hata ");
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });

        });

    });
</script>

