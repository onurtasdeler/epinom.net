<script>

    function deleteModal(id, tur) {

        var a = "";

        var turs = tur;

        $.post("<?= base_url('get-record') ?>", {

            data: 1,

            table: "table_options"

        }, function(response) {

            if (response) {

                $("#makaleId").html('<strong style="color:green">Resim Silinecektir. Emin misiniz ?</strong>');

                $("#silinecek").val(id);

                $("#tur").val(turs);

            } else {

                alertToggle(2, "Bir hata meydana geldi.", "hata ");

            }

        });

    }



    function deleteModalSubmit() {

        var a = $("#silinecek").val();

        var tur = $("#tur").val();

        if (a != "") {

            if (tur == 7) {

                $.post("<?= base_url('image-deletes') ?>", {

                    data: a,

                    tur: tur,

                    table: "table_options",

                    field: "icon_vitrin",

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

            } else if (tur == 8) {

                $.post("<?= base_url('image-deletes') ?>", {

                    data: a,

                    tur: tur,

                    table: "table_options",

                    field: "icon_otomatik",

                    folder: "icon"

                }, function(response) {

                    if (response) {

                        if (response.hata == "var") {

                            alertToggle(1, "Resim Silindi.", "Başarılı");

                            setTimeout(function() {

                                window.location.reload();

                            }, 1000);

                        } else {

                            alertToggle(2, "Hata", "Hata");

                        }



                    } else {

                        alertToggle(2, "Hata", "Hata");

                    }

                });

            } else if (tur == 9) {

                $.post("<?= base_url('image-deletes') ?>", {

                    data: a,

                    tur: tur,

                    table: "table_options",

                    field: "icon_dogrulanmis",

                    folder: "icon"

                }, function(response) {

                    if (response) {

                        if (response.hata == "var") {

                            alertToggle(1, "Resim Silindi.", "Başarılı");

                            setTimeout(function() {

                                window.location.reload();

                            }, 1000);

                        } else {

                            alertToggle(2, "Hata", "Hata");

                        }



                    } else {

                        alertToggle(2, "Hata", "Hata");

                    }

                });

            }



        }

    }



    $(document).ready(function() {



        $('#comissionForm').on('submit', function(e) {

            const formUrl = $(this).attr('action');

            e.preventDefault();

            $.ajax({

                url: formUrl,

                type: 'POST',

                dataType: 'json',

                data: $(this).serialize(),

                success: function(response) {

                    if (response) {

                        if (response.status === false) {

                            alertS(response.message, "error");

                        } else {

                            alertS(response.message, "success");

                        }

                    } else {

                        alertToggle(2, "Bir hata meydana geldi.", "hata ");

                    }

                }

            });

        });



        $("#guncelleForm").on("submit", function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({

                url: "<?= base_url("settings-update/ilan") ?>",

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

        

        $("#guncelleForm2").on("submit", function(e) {

            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({

                url: "<?= base_url("settings-update/ilan") ?>",

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



    function newComission() {

        var htmlCode = `

        <div class="row d-flex justify-content-center">

                                                    <div class="col-5">

                                                        <div class="form-group">

                                                            <label style="font-weight: 600">X TL 'ye Kadar</label>

                                                            <input type="number" step="0.1" class="form-control" name="price[]"

                                                                placeholder="X TL 'ye Kadar">

                                                        </div>

                                                    </div>

                                                    <div class="col-5">

                                                        <div class="form-group">

                                                            <label style="font-weight: 600">Y TL Komisyon</label>

                                                            <input type="number" step="0.1" class="form-control" name="comission[]"

                                                                placeholder="Y TL Komisyon">

                                                        </div>

                                                    </div>

                                                    <div class="col-2 d-flex align-items-center">

                                                        <a href="javascript:;" class="btn btn-primary font-weight-bolder text-uppercase w-100" onclick="newComission()"

                                                            id="addButton">+ Yeni Ekle</a>

                                                        <a href="javascript:;" class="btn btn-danger font-weight-bolder text-uppercase w-100" onclick="deleteComission(this)"

                                                            id="addButton">Sil</a>

                                                    </div>

                                                </div>

        `;

        $("#comissionArea").append(htmlCode);

    }



    function deleteComission(e) {

        $(e).parent().parent().remove();

    }

</script>