<script>
    function deleteModal(id, tur) {
        var a = "";
        var tur = tur;
        $.post("<?= base_url('get-record') ?>", {
            data: id,
            table: "table_theme_options"
        }, function(response) {
            if (response) {
                $("#makaleId").html('<strong style="color:green">Resim Silinecektir. Emin misiniz ?</strong>');
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
            $.post("<?= base_url('image-deletes') ?>", {
                data: a,
                tur: tur,
                table: "table_theme_options",
                field: "home_populer_img_1",
                folder: "icon"
            }, function(response) {
                if (response) {
                    if (response.hata == "var") {
                        alertToggle(2, "Hata", response.message);
                    } else {
                        alertToggle(1, "Resim Silindi.", "Başarılı");
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    }

                } else {
                    alertToggle(2, "Hata", "Hata");
                }
            });
        }
    }

    $(document).ready(function() {

        $("#guncelleForm").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: "<?= base_url("settings-update/tema") ?>",
                type: 'POST',
                data: formData,
                success: function(response) {
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

<?php foreach ($data["siteColors"] as $renk): ?>
    <script>
        $(document).ready(function() {
            var classicPickrDemo = document.querySelectorAll(".<?= $renk->color_name ?>-colorpicker"),
                monolithColorPickr =
                classicPickrDemo &&
                Array.from(classicPickrDemo).forEach(function() {
                    Pickr.create({
                        el: ".<?= $renk->color_name ?>-colorpicker",
                        theme: "classic",
                        default: "<?= $renk->color_code ?>",
                        swatches: [
                            "rgba(244, 67, 54, 1)",
                            "rgba(233, 30, 99, 0.95)",
                            "rgba(156, 39, 176, 0.9)",
                            "rgba(103, 58, 183, 0.85)",
                            "rgba(63, 81, 181, 0.8)",
                            "rgba(33, 150, 243, 0.75)",
                            "rgba(3, 169, 244, 0.7)",
                            "rgba(0, 188, 212, 0.7)",
                            "rgba(0, 150, 136, 0.75)",
                            "rgba(76, 175, 80, 0.8)",
                            "rgba(139, 195, 74, 0.85)",
                            "rgba(205, 220, 57, 0.9)",
                            "rgba(255, 235, 59, 0.95)",
                            "rgba(255, 193, 7, 1)",
                        ],
                        components: {
                            preview: !0,
                            opacity: !0,
                            hue: !0,
                            interaction: {
                                hex: !0,
                                rgba: !0,
                                hsva: !0,
                                input: !0,
                                clear: !0,
                                save: !0
                            }
                        },
                    }).on('save', (color, instance) => {
                        $("#<?= $renk->color_name ?>").val(color.toHEXA().toString());
                    });
                })
        });
    </script>
<?php endforeach; ?>